<?php

namespace Koolbeans\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Koolbeans\CoffeeShop;
use Koolbeans\User;

class SendEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly emails.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (CoffeeShop::all() as $coffeeShop) {
            $q = \DB::select(<<<RAW
SELECT COUNT(*) as aggregate, product_id
FROM order_lines JOIN orders ON orders.id = order_lines.order_id
WHERE coffee_shop_id = {$coffeeShop->id}
AND orders.created_at > orders.created_at - INTERVAL 7 day
GROUP BY product_id
ORDER BY aggregate DESC
RAW
            );

            \Mail::send('emails.sales_overview', [
                'user'       => $coffeeShop->user,
                'mostBought' => $q,
                'coffeeShop' => $coffeeShop,
                'total'      => $coffeeShop->orders()->wherePaid(true)->sum('price') / 100.,
            ], function (Message $m) use ($coffeeShop) {
                $m->to('thomas.ruiz.perso@gmail.com', $coffeeShop->user->name)
                  ->subject('Koolbeans - Your sales overview.');
            });
        }

        foreach (User::all() as $user) {
            $q = \DB::select(<<<RAW
SELECT DISTINCT(o.coffee_shop_id) as id, coffee_shops.name
FROM users
JOIN orders o ON o.user_id = users.id
LEFT JOIN coffee_shop_has_reviews ratings ON ratings.coffee_shop_id <> o.coffee_shop_id
JOIN coffee_shops ON o.coffee_shop_id = coffee_shops.id
WHERE users.id = $user->id
RAW
            );

            if ($user->isOwner()) {
                continue;
            }

            \Mail::send('emails.weekly_overview', [
                'user'        => $user,
                'coffeeShops' => $q,
                'total'       => $user->orders()->wherePaid(true)->sum('price') / 100.,
            ], function (Message $m) use ($user) {
                $m->to('thomas.ruiz.perso@gmail.com', $user->name)->subject('Koolbeans - Weekly overview.');
            });
        }
    }
}
