<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'dachi301',
            'email' => 'dachi301@gmail.com',
            'password' => 'testpass123',
        ]);

        $this->call(QuestionSeeder::class);
    }
}
