<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
        ]);

        $role = \App\Models\Role::where('name', 'user')->first();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> Hash::make('password'),
            'role_id' => $role->id,
        ]);

        $adminRole = \App\Models\Role::where('name','admin')->first();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);

        $this->call([
            ProductsSeeder::class,
            BannersSeeder::class,
        ]);
    }
}
