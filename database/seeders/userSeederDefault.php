<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class userSeederDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



       User::create(
        [
            'username' => 'Administrator',
            'email' => 'administrator@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'posisi' => 'Administrator User',
            'image' => '1.png'
        ],

    );




    }
}
