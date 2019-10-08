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

        $scraped = new sq\Scraper(['dishwashers']);

        $scrap = $scraped->scraped();

        $request = new \Illuminate\Http\Request($scrap);

        // dump($scrap[0]);

        app('\App\Http\Controllers\ProductController')->store($request);

        $tiempo_final = microtime(true);
        $tiempo = $tiempo_final - $tiempo_inicial;
        echo "Tiempo de ejecución: $tiempo segundos\n";
    }
}
