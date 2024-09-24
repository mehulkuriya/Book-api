<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        // Create a default admin user
        User::updateOrCreate([
            'email' => 'admin@example.com',
        ],[
            'name' => 'Admin User',
            'password' => Hash::make('password'),
        ]    
        );
    
    }
}
