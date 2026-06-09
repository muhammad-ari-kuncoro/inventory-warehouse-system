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
            'username'  => 'Administrator',
            'email'     => 'administrator@armindojaya.co.id',
            'password'  => bcrypt('admin123'),
            'role'      => 'Administrator',
            'posisi'    => 'Administrator User',
            'image'     => '1.png'
        ],
    );
    User::create(
        [
            'username' => 'Production User',
            'email'    => 'productionUser@armindojaya.co.id',
            'password' => bcrypt('admin321'),
            'role'     => 'Production',
            'posisi'   => 'Supervisor Production',
            'image'    => '2.png'
        ],
    );
    User::create(
        [
            'username' => 'Warehouse Staff Admin Gudang',
            'email'    => 'warehouseStaffAdmin@armindojaya.co.id',
            'password' => bcrypt('admin123'),
            'role'     => 'Warehouse Staff',
            'posisi'   => 'Admin Gudang',
            'image'    => '7.png'
        ],
    );




    }
}
