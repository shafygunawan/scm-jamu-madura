<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Manager', 'Produksi', 'Gudang', 'Distributor'];

        foreach ($roles as $role) {
            User::firstOrCreate([
                'email' => strtolower($role) . '@example.com'
            ], [
                'name' => $role,
                'password' => Hash::make('password'),
                'role' => $role,
            ]);
        }
    }
}
