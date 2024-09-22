<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = config('app.initial_user.name');
        $user->email = config('app.initial_user.email');
        $user->password = Hash::make(config('app.initial_user.password'));
        $user->save();
    }
}
