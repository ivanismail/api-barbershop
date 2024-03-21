<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->truncate();

        // insert data ke table general_settings
        DB::table('general_settings')->insert([
            ['code' => 'STS', 'value' => '1', 'value_2' => '', 'description' => 'Menunggu Pembayaran', 'active' => true],            
            ['code' => 'STS', 'value' => '2', 'value_2' => '', 'description' => 'Menunggu Antrian', 'active' => true],
            ['code' => 'STS', 'value' => '3', 'value_2' => '', 'description' => 'Selesai', 'active' => true],
            ['code' => 'STS', 'value' => '4', 'value_2' => '', 'description' => 'Batal', 'active' => true],
            ['code' => 'PAYMENT', 'value' => '1', 'value_2' => '', 'description' => 'Tunai', 'active' => true],            
            ['code' => 'PAYMENT', 'value' => '2', 'value_2' => '', 'description' => 'GOPAY', 'active' => true]
        ]);
    }
}
