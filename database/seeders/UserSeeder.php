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
            'password' => '$10$3sOXRqF0BBS/JRCne7vxvOon6PMfZpKdZWdQDpLkZH3ssqe54NtSe',
            'active' => true,
        ]);
    }
}
