<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'bifei',
            'password' => bcrypt('asd123'),
            'email' => str_random(10).'qq.com',
            'username'=>'bifei'
        ]);
    }
}
