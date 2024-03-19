<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('service_categories')->truncate();
        DB::table('service_categories')->insert([
        	['category_name' => 'Potong Rambut','active' => true],
            ['category_name' => 'Potong Jenggot','active' => true],
            ['category_name' => 'Cat Rambut','active' => true]
        ]);
    }
}
