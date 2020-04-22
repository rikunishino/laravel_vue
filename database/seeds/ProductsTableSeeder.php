<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'subject_id' => 1,
                'product_name' => '国語の教科書',
                'price' => '2400',
                'sort_no' => 0,
            ],
            [
                'subject_id' => 1,
                'product_name' => '国語のドリル',
                'price' => '1500',
                'sort_no' => 1,
            ],
            [
                'subject_id' => 1,
                'product_name' => '国語のノート',
                'price' => '700',
                'sort_no' => 2,
            ],
            [
                'subject_id' => 2,
                'product_name' => '算数の教科書',
                'price' => '2600',
                'sort_no' => 0,
            ],
            [
                'subject_id' => 2,
                'product_name' => '算数のドリル',
                'price' => '1800',
                'sort_no' => 1,
            ],
            [
                'subject_id' => 2,
                'product_name' => '算数のドリル2',
                'price' => '1600',
                'sort_no' => 2,
            ],
            [
                'subject_id' => 2,
                'product_name' => '算数のノート',
                'price' => '600',
                'sort_no' => 3,
            ],
            [
                'subject_id' => 3,
                'product_name' => '理科の教科書',
                'price' => '3000',
                'sort_no' => 0,
            ],
            [
                'subject_id' => 3,
                'product_name' => '理科のノート',
                'price' => '900',
                'sort_no' => 1,
            ],
            [
                'subject_id' => 4,
                'product_name' => '社会の教科書',
                'price' => '2800',
                'sort_no' => 0,
            ],
            [
                'subject_id' => 4,
                'product_name' => '社会のノート',
                'price' => '800',
                'sort_no' => 1,
            ],
            [
                'subject_id' => 5,
                'product_name' => '英語の教科書',
                'price' => '1200',
                'sort_no' => 0,
            ],
            [
                'subject_id' => 5,
                'product_name' => '英語のドリル',
                'price' => '1100',
                'sort_no' => 1,
            ],
            [
                'subject_id' => 5,
                'product_name' => '英語のノート',
                'price' => '700',
                'sort_no' => 2,
            ],
        ]);
    }
}
