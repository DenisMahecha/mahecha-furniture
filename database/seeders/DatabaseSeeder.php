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
        User::updateOrCreate(['email' => 'denismahecha2004@gmail.com'], [
            'name' => 'Test User',
            'email' => 'denismahecha2004@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Dewizboe@2004'), ]);

        $this->call(ProductSeeder::class);
    }
}
