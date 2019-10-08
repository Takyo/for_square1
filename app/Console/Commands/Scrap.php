<?php

namespace App\Console\Commands;


use Goutte\Client;
use Illuminate\Console\Command;
use App\lib\Square1 as sq;
use App\Http\Controllers\ProductController;

class Scrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tiempo_inicial = microtime(true);

        $scraped = new sq\Scraper(['small_appliances','dishwashers']);

        $scrap = $scraped->scraped();

        $request = new \Illuminate\Http\Request($scrap);
        dump(count($scrap) .' items found in the scrap');
        // dump($scrap[0]);

        $status = app('\App\Http\Controllers\ProductController')->store($request);
        if ($status) {
            dump('Saved to database');
        }
        $tiempo_final = microtime(true);
        $tiempo = gmdate('H:i:s',$tiempo_final - $tiempo_inicial);
        dump("Tiempo de ejecución: $tiempo");
    }
}
