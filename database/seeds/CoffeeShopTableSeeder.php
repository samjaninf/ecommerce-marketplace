<?php

use Illuminate\Database\Seeder;
use Koolbeans\CoffeeShop;

class CoffeeShopTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('coffee_shops')->delete();

        $users = \Koolbeans\User::where('name', 'like', 'Coffee%')->get();

        foreach ($users as $i => $user) {
            CoffeeShop::create([
                'user_id'   => $user->id,
                'name'      => $user->name . ' Displayed',
                'location'  => 'Canterbury, Kent',
                'latitude'  => rand(-176000, 176000) / 1000,
                'longitude' => rand(-176000, 176000) / 1000.,
                'featured'  => $i > 5 ? true : false,
                'status'    => $i > 3 ? 'published' : 'accepted',
            ]);
        }
    }
}
