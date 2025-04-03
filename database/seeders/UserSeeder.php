<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Rylan Dunning',
                'email' => 'brdunning14@gmail.com',
                'email_verified_at' => null,
                'password' => bcrypt(value: 'password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        User::insert($users);
    }
}
