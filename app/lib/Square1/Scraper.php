<?php
namespace App\lib\Square1;

use Illuminate\Support\Facades\DB;
use Goutte\Client;
use Illuminate\Support\Facades\Config;
use Image;


/**
 *
 */
class Scraper {

    private $client;

    private $scrapeCategories;

    private $products;

    private $config;

    public function __construct(array $scrapeCategories) {
        $this->client = new Client();
        $this->scraperCategories = $scrapeCategories;
        $this->products = [];
        $this->config = Config::get('scraper');
    }

    /**
     * get category config from /config/scrap.php file
     * @param string $category
     * @return array
     */
    public function getCategoryConfig($category) {
        $defaultConfig = $this->config['default'];
        $categoryConfig = $this->config['categories'][$category];
        $conf = array_merge($defaultConfig,$categoryConfig);
        if (array_key_exists('imgs', $categoryConfig)) {
            $conf['imgs'] = array_merge($defaultConfig['imgs'],$categoryConfig['imgs']);
        }
        if (array_key_exists('others', $categoryConfig)) {
            $conf['others'] = array_merge($defaultConfig['others'],$categoryConfig['others']);
        }
        return $conf;
    }


    /**
     * scrape all categories
     * @param  array optional $scrapeCategories
     * @return array $this->products
     */
    public function scraped(array $scrapeCategories = null)
    {
        $scrapeCategories = is_null($scrapeCategories) ? $this->scraperCategories : $scrapeCategories;

        foreach ($scrapeCategories as $category) {

            $conf = $this->getCategoryConfig($category);

            if (!file_exists(public_path($conf['img_path']))) {
                //Storage::makeDirectory(public_path($config['img_path']));
                mkdir(public_path($conf['img_path']));
            }

            $crawler = $this->client->request('GET', $conf['url']);

            $strNum = $crawler->filter($conf['products_number'])->first()->html();
            $prodNum = intval(preg_replace('/[^0-9]+/', '', $strNum), 10);

            $crawlerLast = $crawler->selectLink($conf['click_last']);
            $crawlerNext = $crawler->selectLink($conf['click_next']);

            $lastUri = "";
            if ($crawlerNext->count()) {

                $clickNext = $crawlerNext->link();
                if ($crawlerLast->count()) {
                    $lastUri = $crawlerLast->link()->getUri();
                } else {
                    $lastUri = $clickNext->getUri();
                }
            } else {
                $lastUri = $crawler->getUri();
            }


            $secondRound = true;

            do {

                // click only in the second loop
                if (!$secondRound) {
                    $crawler = $client->click($clickNext);
                    $crawlerNext = $crawler->selectLink($config['click_next']);
                    if ($crawlerNext->count()) {
                        $clickNext = $crawlerNext->link();
                    }
                }
                $secondRound = false;

                $pageProducts = $crawler->filter($conf['item'])->each(function($node) use($conf, $category) {

                    $properties = $node->filter($conf['properties'])->each(function($nodeProp) {
                        $propLin = $nodeProp->text();
                        if (($pos = strpos($propLin, ":")) !== FALSE) {
                            $prop = substr($propLin, 0, $pos);
                            $cont = substr($propLin, $pos+1);
                            return [$prop => trim($cont)];
                        }
                    });

                    $moreInfo = $node->filter($conf['more_info'])->each(function($nodeProp) {
                        return trim($nodeProp->text());
                    });

                    $ret = [
                        'category' => $category,
                        'link' => $node->filter($conf['link'])->link()->getUri(),
                        'more_info' => $moreInfo,
                        'properties' => $properties,
                    ];
                    foreach ($conf['imgs'] as $key => $filter) {
                        if ($node->filter($filter)->count()) {
                            $img = $node->filter($filter)->first()->attr('data-src');
                            $filename = basename($img);
                            $imgPath = public_path("{$conf['img_path']}/$filename");
                            Image::make($img)->save($imgPath);
                            $ret['imgs'][$key] = $imgPath;
                        } else {
                            // $ret['imgs'][$key] = null;
                        }
                    }

                    $ret2 = array_map(function($key) use($node){

                        if (!empty($key) && $node->filter($key)->count()) {
                            return $node->filter($key)->html();
                        } else {
                            return null;
                        }
                    }, $conf['others']);

                    $ret2['coin'] = mb_substr($ret2['price'], 0, 1, 'utf8');
                    $ret2['price'] = mb_substr($ret2['price'], 1, null, 'utf8');
                    if (array_key_exists("rrp", $ret2) && !is_null($ret2['rrp'])) {
                        $ret2['rrp'] = mb_substr($ret2['rrp'], 1, null, 'utf8');
                    }
                    return  array_merge($ret, $ret2);

                });

                $this->products = array_merge($this->products, $pageProducts);

             } while($crawler->getUri() !== $lastUri) ;

            return $this->products;
        }
    }

    /**
    * Convert all products to json
    * @return json
    */
    public function toJson() {
        return json_encode($this->products);
    }

}


?>