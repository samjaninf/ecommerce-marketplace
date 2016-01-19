<?php

namespace Koolbeans\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Koolbeans\Transaction;
use Koolbeans\User;
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
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $transactions = Transaction::whereCharged(false)->orderByRaw('user_id, created_at')->get();

            $stripe_charge_id = null;
            $amount           = 0;
            $userId           = -1;
            $user             = null;
            $saved            = null;
            foreach ($transactions as $transaction) {
     
                    echo $transaction->stripe_charge_id;
                    $charge1 = Charge::retrieve($transaction->stripe_charge_id);

                    echo $charge1->capture();

                    $saved->charged = true;
                    $saved->save();

                    $userId           = -1;
                    $stripe_charge_id = null;
                    $amount           = 0;

                    \Mail::send('emails.payment_charged', [
                        'user'    => $user,
                        'amount'  => $amount / 100.,
                        'refund'  => ( 1500 - $amount ) / 100.,
                        'initial' => 15.00,
                    ], function (Message $m) use ($user) {
                        $m->to($user->email, $user->name)->subject('You have been charged.');
                    });
                
                if ($transaction->stripe_charge_id) {
                    $currentDate = Carbon::now();
                    if ($currentDate->diffInDays($transaction->created_at) < 6) {
                        continue;
                    }

                    $amount += $transaction->amount;

                    $saved            = $transaction;
                    $stripe_charge_id = $transaction->stripe_charge_id;
                    $userId           = $transaction->user_id;
                    $user             = User::find($userId);
                } elseif ($stripe_charge_id != null) {
                    $amount += $transaction->amount;

                    $saved->amount += $transaction->amount;
                    $saved->save();

                    $transaction->charged = true;
                    $transaction->save();
                }
            }

            if ($stripe_charge_id != null) {
                $charge = Charge::retrieve($stripe_charge_id);
                $charge->capture(['amount' => $amount]);

                \Mail::send('emails.payment_charged', [
                    'user'    => $user,
                    'amount'  => $amount / 100.,
                    'refund'  => ( 1500 - $amount ) / 100.,
                    'initial' => 15.00,
                ], function (Message $m) use ($user) {
                    $m->to($user->email, $user->name)->subject('You have been charged.');
                });

                $saved->charged = true;
                $saved->save();
            }

            return 0;
        } catch (\Exception $e) {
            echo $e;
            \Mail::send('emails.FAILURE', [], function (Message $m) {
                $m->to('gouldmatt99@hotmail.com');
            });
        }
    }
}
