<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 全件削除
        DB::table('subjects')->truncate();

        DB::table('subjects')->insert([
            ['name' => '国語'],
            ['name' => '算数'],
            ['name' => '理科'],
            ['name' => '社会'],
            ['name' => '英語'],
        ]);
    }
}
