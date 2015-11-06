<?php

use Illuminate\Database\Seeder;

class ProductTablePop extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   
        \Koolbeans\Product::firstOrCreate([
        	'name' => 'Skinny Latte',
            'type' => 'drink',            
            'description' => 'As per its title, the Latte is made skinny by using skimmed milk rather than full fat milk.',
        ]); 

    }
}
