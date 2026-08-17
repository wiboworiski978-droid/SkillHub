<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'bio' => 'Administrator SkillHub',
            'skill' => 'Management',
            'school' => 'SkillHub',
        ]);

                User::create([
            'username' => 'user',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'bio' => 'User SkillHub',
            'skill' => 'Design',
            'school' => 'SMK',
        ]);
    }
}
