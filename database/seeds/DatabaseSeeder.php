<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $config = Config::get('scraper.categories');

        $catDB = DB::table('categories');

        DB::statement("SET foreign_key_checks=0");
        $catDB->truncate();
        DB::statement("SET foreign_key_checks=1");

        $now = Carbon::now();
        foreach($config as $key => $value) {
            $catDB->insert([
                'name' => $key,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('users')->insert([
            'name' => 'lazaro',
            'email' => 'lazaro@email.com',
            'password' => bcrypt('1234'),
        ]);
        // factory(App\Product::class, 10)->create();
        // factory(App\User::class)->create(['name' => 'Lázaro' , 'email' => 'lazaro@email.com']);
        // $this->call(UsersTableSeeder::class);
    }
}
