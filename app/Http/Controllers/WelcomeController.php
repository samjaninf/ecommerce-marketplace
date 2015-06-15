<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Http\Request;
use Koolbeans\CoffeeShop;
use Koolbeans\Offer;
use Koolbeans\Repositories\CoffeeShopRepository;

class WelcomeController extends Controller
{

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShops
     *
     * @return \Illuminate\View\View
     */
    public function index(CoffeeShopRepository $coffeeShops)
    {
        $featured    = array_fill(0, 7, null);
        $coffeeShops = $coffeeShops->getFeatured();
        foreach ($coffeeShops as $i => $coffeeShop) {
            if ($i === 1) {
                $featured[6] = $coffeeShop;
            } elseif ($i === 0) {
                $featured[0] = $coffeeShop;
            } else {
                $featured[ $i - 1 ] = $coffeeShop;
            }
        }

        $offers = Offer::whereActivated(true)->get();
        while ($offers->count() < 4) {
            $offers->add(new Offer);
        }

        return view('welcome')->with('featuredShops', $featured)->with('offers', $offers->random(4));
    }

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShops
     * @param null                                         $query
     *
     * @return \Illuminate\View\View
     */
    public function search(CoffeeShopRepository $coffeeShops, $query = null)
    {
        if ($this->request->method() === 'POST') {
            $query = $this->request->get('query');
        }
        $baseQuery = $query;

        $pos = mb_strpos($query, ',');
        $pos = $pos == false ? mb_strpos($query, ' ') : $pos;
        $pos = $pos == false ? 0 : ( $pos + 1 );

        $subQuery = trim(mb_substr($query, $pos));
        $places   = app('places')->nearby($subQuery . ', United Kingdom');
        $city     = app('places')->getPlace($places['predictions'][0]['place_id'])['result'];
        $query    = '%' . str_replace(' ', '%', $query) . '%';

        $orderByRaw = 'abs(abs(latitude) - ' . abs($city['geometry']['location']['lat']) . ') + abs(abs(longitude) - ' .
                      abs($city['geometry']['location']['lng']) . ') asc';

        $shops    = CoffeeShop::where('location', 'like', $query)->orderByRaw($orderByRaw)->paginate(8);
        $position = $city['geometry']['location']['lat'] . ',' . $city['geometry']['location']['lng'];

        return view('search.results', compact('shops', 'position'))->with('query', $baseQuery);
    }
}
