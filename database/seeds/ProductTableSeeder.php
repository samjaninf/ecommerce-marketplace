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

        $hotDrink = new \Koolbeans\ProductType([
            'name' => 'Hot drink',
        ]);

        $product->types()->attach($hotDrink);
        $product->types()->attach(new \Koolbeans\ProductType([
            'name' => 'Coffee',
        ]));

        $coffeeShop = \Koolbeans\CoffeeShop::find(11);
        $coffeeShop->products()->attach($product);

        $product = \Koolbeans\Product::create([
            'type' => 'drink',
            'name' => 'Hot chocolate',
        ]);

        $product->types()->attach($hotDrink);
        $coffeeShop->products()->attach($product);

        $product = \Koolbeans\Product::create([
            'type' => 'food',
            'name' => 'Chocolate muffin',
        ]);

        $product->types()->attach(new \Koolbeans\ProductType([
            'name' => 'Chocolate',
        ]));

        $coffeeShop->products()->attach($product);
        foreach ($coffeeShop->products as $i => $product_) {
            $product_->pivot->activated = true;
            if ($product_->type == 'drink') {
                $product_->pivot->xs_activated = true;
                $product_->pivot->xs           = 134 + $i * 30;

                if ($i == 0) {
                    $product_->pivot->md           = 212;
                    $product_->pivot->md_activated = true;
                    $product_->pivot->sm           = 183;
                    $product_->pivot->sm_activated = true;
                }
            } else {
                $product_->pivot->sm_activated = true;
                $product_->pivot->sm           = 299;
            }

            $product_->pivot->save();
        }
    }
}
