<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class)->create(['name' => 'name01']);
        factory(App\Category::class)->create(['name' => 'name02']);

        factory(App\Product::class, 10)->create();
        factory(App\User::class)->create(['name' => 'Lázaro' , 'email' => 'lazaro@email.com']);
        // $this->call(UsersTableSeeder::class);
    }
}
