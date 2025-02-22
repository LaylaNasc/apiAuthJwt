<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->nome = 'LaylaSantos';
        $user->email = 'layla@gmail.com';
        $user->cargo = 'desenvolvedora';
        $user->password = bcrypt('Abc123456');
        $user->save();
    }
}
