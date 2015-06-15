<?php

if ( ! function_exists('current_user')) {
    /**
     * @return \Koolbeans\User|null
     */
    function current_user()
    {
        return app('auth.driver')->user();
    }
}

/**
 * @param $offerId
 *
 * @return string
 */
function display_offer($offerId)
{
    $offer      = \Koolbeans\Offer::find($offerId);
    $coffeeShop = $offer->coffee_shop;

    $offers = "";
    foreach ($offer->details as $detail) {
        if ($detail->type === 'free') {
            if ($offers != '') {
                $offers .= ', ';
            }

            $offers .= 'Free ' . $coffeeShop->getNameFor($detail->product) . ' (for buying a ' .
                       $coffeeShop->getNameFor($offer->product) . ')';
        } elseif ($detail->type === 'flat') {
            foreach (['xs', 'sm', 'md', 'lg'] as $size) {
                if ($detail->{'amount_' . $size} == 0) {
                    continue;
                }

                if ($offers != '') {
                    $offers .= ', ';
                }

                $offers .= '£ ' . number_format($detail->{'amount_' . $size} / 100., 2) . ' off a ' .
                           $coffeeShop->getNameFor($detail->product) . ' (for buying a ' .
                           $coffeeShop->getNameFor($offer->product) . ')';
            }
        } else {
            foreach (['xs', 'sm', 'md', 'lg'] as $size) {
                if ($detail->{'amount_' . $size} == 0) {
                    continue;
                }

                if ($offers != '') {
                    $offers .= ', ';
                }

                $offers .= $detail->{'amount_' . $size} . '% off a ' .
                           $coffeeShop->getNameFor($detail->product) . ' (for buying a ' .
                           $coffeeShop->getNameFor($offer->product) . ')';
            }
        }
    }

    return $offers . '.';
}
