<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'first_name' => 'Gene',
            'last_name' => 'Artista',
            'email' => 'genephillip@yaho.com',
            'phone' => '1111111111',
            'address' => 'SOmewhewr',
            'gender' => 'Male',
            'birth_date' => now(),
            'created_at' => now(),
            'enabled' => true
        ]);
    }
}
