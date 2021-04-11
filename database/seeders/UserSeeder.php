<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i=0; $i < 1000; $i++) { 
            $data[]= [
                'first_name' => 'Some name',
                'last_name' => 'last name',
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make(Str::random(20)),
                'created_at' => now()
            ];
        }

        $chunks = array_chunk($data, 100);

        foreach ($chunks as $chunk) {
            User::insert($chunk);
        }
    }
}
