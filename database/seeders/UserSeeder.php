<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('users')->truncate();
         //* insert data ke table user
        DB::table('users')->insert([
        	'name' => 'Ivan Ismail',
        	'phone_number' => '+628123456789',
            'password' => '$2y$10$9AvuQce5sU0TJLRRz80Nje3QJlRVZEgmIHGFXhJccc0pFtQzIGAP6',
            'active' => true,
        ]);
    }
}
