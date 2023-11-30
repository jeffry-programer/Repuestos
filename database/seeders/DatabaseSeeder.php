<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $array = [
            [
                'profiles_id' => 1,
                'cities_id' => 1,  
                'name' => 'Jeffry',
                'last_name' => 'Avellaneda',
                'email' => 'jeffryavellaneda@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), 
                'image' => '',
                'gender' => 'M',
                'status' => true,
                'remember_token' => Hash::make('password'), 
                'created_at' => now()
            ]
        ];
        DB::table('users')->insert($array);
    }
}
