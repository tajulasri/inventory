<?php
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return DB::table('categories')
        	->insert([
        		['name' => 'Shoes'],
        		['name' => 'Others']
        		]);
    }
}
