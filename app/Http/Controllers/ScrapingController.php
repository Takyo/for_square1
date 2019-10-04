<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Square1\Square1\Scraper;
use Illuminate\Support\Facades\Config;
use Image;

class ScrapingController extends Controller
{
    public function smallAppliances(Client $client)
    {
        $config = Config::get('scraper.small_appliances');

        $crawler = $client->request('GET', $config['url']);

        $strNum = $crawler->filter($config['products_number'])->first()->html();
        $prodNum = intval(preg_replace('/[^0-9]+/', '', $strNum), 10);
        $lastUri = $crawler->filter($config['click_next'])->last()->link()->getUri();
        $clickNext = $crawler->filter($config['click_next'])->last()->previousAll()->link();

        $products = [];
        $exit = false;

        do {
            if ($crawler->getUri() === $lastUri) {
                $exit = true;
            }

            $pageProducts = $crawler->filter($config['item'])->each(function($node) use($config) {

                $properties = $node->filter($config['properties'])->each(function($nodeProp) {
                    $propLin = $nodeProp->text();
                    if (($pos = strpos($propLin, ":")) !== FALSE) {
                        $prop = substr($propLin, 0, $pos);
                        $cont = substr($propLin, $pos+1);
                        return [$prop => $cont];
                    }
                });

                $ret = [
                    'link' => $node->filter($config['link'])->link()->getUri(),
                    'extended_warranty' => $node->filter($config['extended_warranty'])->count() ? 'true' : 'false',
                    'properties' => $properties,
                ];
                foreach ($config['imgs'] as $key => $filter) {
                    if ($node->filter($filter)->count()) {
                        $img = $node->filter($filter)->first()->attr('data-src');
                        $filename = basename($img);
                        $imgPath = public_path("{$config['path']}/$filename");
                        // Image::make($img)->save($imgPath);
                        $ret['imgs'][$key] = $imgPath;
                    } else {
                        $ret['imgs'][$key] = null;
                    }
                }

                $ret2 = array_map(function($key) use($node){

                    if (!empty($key) && $node->filter($key)->count()) {
                        return $node->filter($key)->html();
                    } else {
                        return null;
                    }
                }, $config['others']);

                return  array_merge($ret,$ret2);
            });

            $products = array_merge($products, $pageProducts);

            // dump($products);

            // next crawler (page);
            $crawler = $client->click($clickNext);
            $clickNext = $crawler->filter($config['click_next'])->last()->previousAll()->link();

        } while (!$exit) ;


    }

    public function dishwashers(Client $client)
    {
    }
}
