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
        return DB::table('users')
        	->insert([
        		['email' => 'mtajulasri@gmail.com','name'=>'tajul asri','password' => bcrypt('password')]
        		]);
    }
}
