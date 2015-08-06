<?php

namespace Koolbeans\Console\Commands;

use Carbon\Carbon;
use Config;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Koolbeans\CoffeeShop;
use Koolbeans\Services\XeroOAuth;

class CreateXeroBillsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:xero';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put on xero what needs to be on xero.';
    /**
     * @var \Koolbeans\Services\XeroAPI
     */
    private $xero;

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
        $coffeeShops = CoffeeShop::has('orders')->with('orders')->whereHas('orders', function (Builder $q) {
            $q->where('on_xero', false);
        })->get();

        $invoices = [];
        foreach ($coffeeShops as $coffeeShop) {
            $amount = 0;
            foreach ($coffeeShop->orders as $order) {
                if ($order->paid) {
                    $amount += $order->price;
                }
            }

            if ($amount > 0) {
                $invoices[] = $this->createInvoice($coffeeShop, $amount * .8 / 100);
            }
        }

        $this->sendXML($this->invoicesToXml($invoices));
    }

    /**
     * @param \Koolbeans\CoffeeShop $coffeeShop
     * @param int                   $amount
     *
     * @return array
     */
    public function createInvoice(CoffeeShop $coffeeShop, $amount)
    {
        return [
            'contact' => $coffeeShop->getXeroName(),
            'desc'    => $coffeeShop->getXeroName() . ' bill: 80% of the total revenue of the shop',
            'amount'  => $amount,
            'date_'   => Carbon::now()->format('Y-m-d'),
            'due'     => Carbon::now()->addWeek(4)->format('Y-m-d'),
        ];
    }

    /**
     * @param array $invoices
     *
     * @return array
     */
    private function invoicesToXml(array $invoices)
    {
        $xmls = [];
        foreach ($invoices as $invoice) {
            $xml = <<<XML
<Invoice>
    <Type>ACCPAY</Type>
    <Contact>
        <Name>$invoice[contact]</Name>
    </Contact>
    <CurrencyCode>GBP</CurrencyCode>
    <Date>$invoice[date_]</Date>
    <DueDate>$invoice[due]</DueDate>
    <LineItems>
        <LineItem>
            <Description>$invoice[desc]</Description>
            <Quantity>1</Quantity>
            <UnitAmount>$invoice[amount]</UnitAmount>
            <ItemCode>Sales</ItemCode>
        </LineItem>
    </LineItems>
</Invoice>
XML;

            $xmls[] = $xml;
        }

        return $xmls;
    }

    /**
     * @param array $xml
     */
    private function sendXML(array $xml)
    {
        $xmls      = new Collection($xml);
        $XeroOAuth = new XeroOAuth(Config::get('services.xero'));

        foreach ($xmls->chunk(50) as $chunk) {
            $chunk    = "<Invoices>" . implode("\n", $chunk->toArray()) . "</Invoices>";
            $response =
                $XeroOAuth->request('PUT', $XeroOAuth->url('Invoices', 'core'), ['summarizeErrors' => 'false'], $chunk,
                    'json');
            $body     = json_decode($response['response']);

            foreach ($body->Invoices as $invoice) {
                if ("OK" === $invoice->StatusAttributeString) {
                    $contact    = $invoice->Contact->Name;
                    $id         = mb_substr($contact, mb_strrpos($contact, '_') + 1);
                    $coffeeShop = CoffeeShop::find($id);

                    $coffeeShop->orders()->update(['on_xero' => true]);
                }
            }
        }
    }
}
