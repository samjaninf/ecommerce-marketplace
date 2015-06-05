<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('products')->delete();

        $product = \Koolbeans\Product::create([
            'type' => 'drink',
            'name' => 'Americano',
        ]);

        $product->types()->attach(new \Koolbeans\ProductType([
            'name' => 'Hot drink',
        ]));
        $product->types()->attach(new \Koolbeans\ProductType([
            'name' => 'Coffee',
        ]));

        $coffeeShop = \Koolbeans\CoffeeShop::find(11);
        $coffeeShop->products()->attach($product);
        $coffeeShop->products[0]->pivot->activated    = true;
        $coffeeShop->products[0]->pivot->xs_activated = true;
        $coffeeShop->products[0]->pivot->xs           = 134;
        $coffeeShop->products[0]->pivot->save();
    }
}
