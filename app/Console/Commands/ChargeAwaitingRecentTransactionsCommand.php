<?php

namespace Koolbeans\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Koolbeans\Transaction;
use Stripe\Charge;
use Stripe\Stripe;

class ChargeAwaitingRecentTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge the awaiting transactions';

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
        Stripe::setApiKey(config('services.stripe.secret'));
        $transactions = Transaction::whereCharged(false)->orderByRaw('user_id, created_at')->get();

        $stripe_charge_id = null;
        $amount           = 0;
        $userId           = -1;
        foreach ($transactions as $transaction) {
            if ($userId != -1 && $userId !== $transaction->user_id) {
                $charge = Charge::retrieve($stripe_charge_id);
                $charge->capture(['amount' => $amount]);

                $userId           = -1;
                $stripe_charge_id = null;
                $amount           = 0;
            }

            if ($transaction->stripe_charge_id) {
                $currentDate = Carbon::now();
                if ($currentDate->diffInDays($transaction->created_at) < 6) {
                    continue;
                }

                $stripe_charge_id = $transaction->stripe_charge_id;
                $userId           = $transaction->user_id;
            }

            if ($stripe_charge_id != null) {
                $amount += $transaction->amount;
            }
        }

        $charge = Charge::retrieve($stripe_charge_id);
        $charge->capture(['amount' => $amount]);

        return 0;
    }
}
