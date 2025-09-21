<?php

namespace Database\Seeders;

use App\Models\IpAddress;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        if (!User::where('email', 'admin@gmail.com')->exists())
        User::factory()->create([
            'name' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'password'=>12345
        ]);

       IpAddress::factory(50)->create();

    }
}
