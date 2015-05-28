<?php

use Illuminate\Database\Seeder;
use Koolbeans\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('users')->delete();

        User::create([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'John Smith',
            'email'    => 'email@example.com',
            'password' => Hash::make('password'),
        ]);

        for ($i = 1; $i <= 10; ++$i) {
            User::create([
                'name'     => 'Coffee shop ' . $i,
                'email'    => 'coffee_shop' . $i . '@example.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
