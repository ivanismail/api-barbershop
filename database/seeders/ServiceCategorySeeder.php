<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->truncate();
        DB::table('services')->insert([
        	['category_id' => '1','service_name' => 'Potong Rambut Dewasa','price' => '20000','desc' => 'Perkiraan 30 Menit','active' => true],
            ['category_id' => '1','service_name' => 'Potong Rambut Anak','price' => '15000','desc' => 'Perkiraan 30 Menit','active' => true],
            ['category_id' => '1','service_name' => 'Potong Rambut Botak Plontos','price' => '25000','desc' => 'Perkiraan 30 Menit','active' => true],
            ['category_id' => '2','service_name' => 'Potong Rambut Jenggot','price' => '15000','desc' => 'Perkiraan 30 Menit','active' => true],
            ['category_id' => '3','service_name' => 'Cat Warna Merah (Sasha)','price' => '30000','desc' => 'Perkiraan 30 Menit','active' => true]
        ]);
    }
}
