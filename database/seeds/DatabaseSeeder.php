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
        $this->call(SubjectsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(CorporationsTableSeeder::class);
        $this->call(SchoolsTableSeeder::class);
    }
}
