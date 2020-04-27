<?php

use Illuminate\Database\Seeder;

class CorporationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('corporations')->insert([
            [
                'login_id'=>'stone_user',
                'password'=>'test1234',
                'name'=>'StoneSystem',
                'mail'=>'stone@stonesystem.co.jp',
                'address'=>'〇〇県××市△△町',
                'postal_code'=>'000-0000',
                'tel'=>'111-1111',
                'fax'=>'111-2222'
            ],
            [
                'login_id'=>'example',
                'password'=>'password',
                'name'=>'Example',
                'mail'=>'example@example.co.jp',
                'address'=>'bb県dd市kk町',
                'postal_code'=>'999-9999',
                'tel'=>'888-9999',
                'fax'=>'888-8888'
            ]
        ]);
    }
}
