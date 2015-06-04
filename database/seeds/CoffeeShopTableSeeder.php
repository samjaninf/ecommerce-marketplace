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

        CoffeeShop::create([
            'user_id'   => 2,
            'name'      => 'The white sugar',
            'location'  => 'Canterbury, Kent',
            'latitude'  => 51.2785451,
            'longitude' => 1.0780975000000126,
            'featured'  => false,
            'status'    => 'accepted',
        ]);
    }
}
