<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // Delete test user first
        User::where('ic', '990101011111')->delete();
        
        // Create one user
        $user = User::create([
            'ic' => '990101011111',
            'name' => 'TEST SEEDER USER',
            'password' => Hash::make('qwerty'),
            'role' => 'staff',
            'status' => 'active',
        ]);
        
        echo "\n Created user: " . $user->name;
        echo "\n📅 Date of Birth: " . $user->date_of_birth;
        echo "\n🎂 Age: " . $user->age . "\n\n";
    }
}