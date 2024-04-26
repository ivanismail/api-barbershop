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
            ['code' => 'STS', 'value' => '3', 'value_2' => '', 'description' => 'Sedang Dicukur', 'active' => true],
            ['code' => 'STS', 'value' => '4', 'value_2' => '', 'description' => 'Selesai', 'active' => true],
            ['code' => 'STS', 'value' => '5', 'value_2' => '', 'description' => 'Batal', 'active' => true],
            ['code' => 'PAYMENT', 'value' => '1', 'value_2' => '', 'description' => 'Tunai', 'active' => true],            
            ['code' => 'PAYMENT', 'value' => '2', 'value_2' => '', 'description' => 'Poin', 'active' => true],
            ['code' => 'PAYMENT', 'value' => '3', 'value_2' => '', 'description' => 'Gopay', 'active' => false],
            ['code' => 'schedule', 'value' => '9', 'value_2' => '', 'description' => '09:00', 'active' => true],
            ['code' => 'schedule', 'value' => '10', 'value_2' => '', 'description' => '10:00', 'active' => true],
            ['code' => 'schedule', 'value' => '11', 'value_2' => '', 'description' => '11:00', 'active' => true],
            ['code' => 'schedule', 'value' => '13', 'value_2' => '', 'description' => '13:00', 'active' => true],
            ['code' => 'schedule', 'value' => '14', 'value_2' => '', 'description' => '14:00', 'active' => true],
            ['code' => 'schedule', 'value' => '15', 'value_2' => '', 'description' => '15:00', 'active' => true],
            ['code' => 'schedule', 'value' => '16', 'value_2' => '', 'description' => '16:00', 'active' => true],
            ['code' => 'schedule', 'value' => '17', 'value_2' => '', 'description' => '17:00', 'active' => true],
            ['code' => 'schedule', 'value' => '19', 'value_2' => '', 'description' => '19:00', 'active' => true],
            ['code' => 'schedule', 'value' => '20', 'value_2' => '', 'description' => '20:00', 'active' => true],
            ['code' => 'REDEM', 'value' => '10', 'value_2' => '', 'description' => 'Minimal Redeem Point', 'active' => true],
        ]);
    }
}
