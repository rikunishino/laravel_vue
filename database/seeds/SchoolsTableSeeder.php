<?php

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schools')->insert([
            [
                'corporation_id' => 1,
                'name' => '麹町小学校'
            ],
            [
                'corporation_id' => 1,
                'name' => '九段小学校'
            ],
            [
                'corporation_id' => 1,
                'name' => '番町小学校'
            ],
            [
                'corporation_id' => 1,
                'name' => '富士見小学校'
            ],
            [
                'corporation_id' => 1,
                'name' => 'お茶の水小学校'
            ],
            [
                'corporation_id' => 2,
                'name' => '〇〇小学校'
            ],
            [
                'corporation_id' => 2,
                'name' => 'xx小学校'
            ],
        ]);
    }
}
