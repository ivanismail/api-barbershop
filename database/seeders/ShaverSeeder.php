<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShaverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shavers')->truncate();
        DB::table('shavers')->insert([
        	['shaver_name' => 'John Legend','active' => true],
            ['shaver_name' => 'Mark','active' => true],
            ['shaver_name' => 'Thomas','active' => true]
        ]);
    }
}
