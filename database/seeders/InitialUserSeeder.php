<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $admin = User::create(['name' => 'admin', 'password' => Hash::make('password'),'email' => 'admin@threls.com']);
       $admin->assignRole('admin');

        $user = User::create(['name' => 'user', 'password' => Hash::make('password'),'email' => 'user@threls.com']);
        $user->assignRole('user');
    }
}
