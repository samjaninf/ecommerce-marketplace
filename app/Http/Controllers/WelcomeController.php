<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Koolbeans\CoffeeShop;
use Koolbeans\MobileToken;
use Koolbeans\Offer;
use Koolbeans\Order;
use Koolbeans\Post;
use Koolbeans\Repositories\CoffeeShopRepository;
use Koolbeans\User;

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

        $posts = Post::orderBy('created_at', 'desc')->limit(2)->get();

        return view('welcome')
            ->with('featuredShops', $featured)
            ->with('posts', $posts)
            ->with('offers', $offers->random(4));
    }

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShops
     * @param null                                         $query
     *
     * @return \Illuminate\View\View
     */
    public function search($query = null)
    {
        $query = \Input::get('q', $query);
        if ($this->request->method() === 'POST') {
            $query = $this->request->get('query');
        }
        $baseQuery = $query;
        $filters   = \Input::get('f', []);

        $pos = mb_strpos($query, ',');
        $pos = $pos == false ? mb_strpos($query, ' ') : $pos;
        $pos = $pos == false ? 0 : ( $pos + 1 );

        $subQuery = trim(mb_substr($query, $pos));
        $query    = '%' . str_replace(' ', '%', $query) . '%';
        $places   = app('places')->nearby($subQuery . ', United Kingdom');
        if ($places['status'] === 'ZERO_RESULTS') {
            $places = app('places')->nearby($subQuery);
            if ($places['status'] === 'ZERO_RESULTS') {
                $tmp = CoffeeShop::where('location', 'like', $query)
                                 ->orWhere('name', 'like', $query)
                                 ->orWhere('county', 'like', $query)
                                 ->orWhere('postal_code', 'like', $query)
                                 ->first();
                if ( ! $tmp) {
                    $shops    = [];
                    $position = null;
                }
            }
        }

        if ( ! isset( $shops )) {
            if ($places['status'] !== 'ZERO_RESULTS') {
                $city = app('places')->getPlace($places['predictions'][0]['place_id'])['result'];

                $orderByRaw =
                    'abs(abs(latitude) - ' . abs($city['geometry']['location']['lat']) . ') + abs(abs(longitude) - ' .
                    abs($city['geometry']['location']['lng']) . ') asc';
            } else {
                $city       = ['address_components' => []];
                $orderByRaw = '';
            }

            $shops = CoffeeShop::where(function (Builder $q) use ($query, $city) {
                $q->where('location', 'like', $query)
                  ->orWhere('name', 'like', $query)
                  ->orWhere('county', 'like', $query)
                  ->orWhere('postal_code', 'like', $query);

                foreach ($city['address_components'] as $c) {
                    $q->orWhere('location', 'like', $c['long_name'])
                      ->orWhere('county', 'like', $c['long_name'])
                      ->orWhere('postal_code', 'like', $c['long_name']);
                    $q->orWhere('location', 'like', $c['short_name'])
                      ->orWhere('county', 'like', $c['short_name'])
                      ->orWhere('postal_code', 'like', $c['short_name']);
                }
            })->where(function (Builder $query) use ($filters) {
                foreach ($filters as $filter => $_) {
                    if (in_array($filter, CoffeeShop::getSpecs())) {
                        $query->where('spec_' . $filter, '=', true);
                    }
                }
            })->orderByRaw($orderByRaw)->paginate(8);

            $position = $city['geometry']['location']['lat'] . ',' . $city['geometry']['location']['lng'];

            if ($places['status'] !== 'ZERO_RESULTS') {
                foreach ($shops as $shop) {
                    $shop->setDistance($this->calculDistance($shop->latitude, $shop->longitude,
                        $city['geometry']['location']['lat'], $city['geometry']['location']['lng']));
                }
            }
        }

        return view('search.results', compact('shops', 'position'))
            ->with('query', $baseQuery)
            ->with('filters', array_keys($filters));
    }

    /**
     * @param $lat
     * @param $lng
     * @param $lat2
     * @param $lng2
     *
     * @return float
     */
    private function calculDistance($lat, $lng, $lat2, $lng2)
    {
        $theta = $lng - $lng2;
        $dist  =
            sin(deg2rad($lat)) * sin(deg2rad($lat2)) + cos(deg2rad($lat)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);

        return $dist * 60 * 1.1515;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function about()
    {
        try {
            $about = \File::get(storage_path('app/about.txt'));
        } catch (FileNotFoundException $e) {
            $about = 'Write me!';
        }

        return view('about')->with('about', $about);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function contactUs()
    {
        $coffeeShop = current_user()->coffee_shop;
        $images     = $coffeeShop->gallery()->orderBy('position')->limit(3)->get();

        return view('contact', compact('coffeeShop'))->with([
            'images'     => $images,
            'firstImage' => $images->isEmpty() ? null : $images[0]->image,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact()
    {
        return redirect()->back()->with('messages', [
            'success' => 'Your message have been sent.',
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAbout(Request $request)
    {
        if (current_user()->role == 'admin') {
            \File::put(storage_path('app/about.txt'), $request->input('about'));
        }

        return redirect()->back();
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function pushToken(Request $request)
    {
        $user = User::find($request->user_id);
        if ($request->has('unregister') && $request->unregister == true) {
            $requestTokens =
                $request->has('_push.ios_tokens') ? $request->_push['ios_tokens'] : $request->_push['android_tokens'];
            $user->mobile_tokens()->whereIn('token', $requestTokens)->delete();

            return;
        }

        if ($request->has('_push')) {
            $requestTokens =
                $request->has('_push.ios_tokens') ? $request->_push['ios_tokens'] : $request->_push['android_tokens'];
            foreach ($requestTokens as $requestToken) {
                $user->mobile_tokens()->firstOrCreate(['token' => $requestToken]);
            }
        } else {
            $requestToken = $request->has('ios_token') ? $request->ios_token : $request->android_token;
            $token        = $user->mobile_tokens()->firstOrNew(['token' => $requestToken]);
            $token->delete();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request)
    {
        if (\Auth::attempt($request->only(['email', 'password']))) {
            return current_user()->id;
        }

        return response('Bad credentials.', 403);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function validateId(Request $request)
    {
        if ($request->id != '') {
            $user = User::find($request->id);

            if ($user) {
                return '';
            }
        }

        return response('', 403);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function getOrder($id)
    {
        $order = Order::whereId($id)->with('order_lines', 'order_lines.product', 'coffee_shop', 'user')->first();

        $return = [];
        foreach ($order->order_lines as $line) {
            $name = $order->coffee_shop->getNameFor($line->product);
            if ( ! isset( $return[ $name ] )) {
                $return[ $name ] = [];
            }

            $size = $order->coffee_shop->getSizeDisplayName($line->size);
            if ( ! isset( $return[ $name ][ $size ] )) {
                $return[ $name ][ $size ] = 0;
            }

            $return[ $name ][ $size ] += 1;
        }

        $return = [
            'order_id'    => $order->id,
            'products'    => $return,
            'pickup_time' => $order->pickup_time,
            'name'        => $order->user->name,
        ];

        return $return;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function orderSent($id)
    {
        $order         = Order::find($id);
        $order->status = 'collected';
        $order->save();

        return '';
    }

    /**
     * @param $token
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|string|\Symfony\Component\HttpFoundation\Response
     */
    public function validateToken($token)
    {
        if (MobileToken::whereToken($token)->count() > 0) {
            return '';
        }

        return response('', 403);
    }
}
