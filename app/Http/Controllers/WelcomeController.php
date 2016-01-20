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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Jenssegers\Agent\Agent;

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

        if (isset($_GET['code'])) {
          $code = $_GET['code'];

          $token_request_body = array(
            'grant_type' => 'authorization_code',
            'client_id' => 'ca_7hpA87d09JFpXVNWgswHbG4ZnzhMyZ2L',
            'code' => $code,
            'client_secret' => 'sk_test_fNCMV9dZEwNvPs3wf2OBBohK'
          );

          $req = curl_init('https://connect.stripe.com/oauth/token');
          curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($req, CURLOPT_POST, true );
          curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));

          // TODO: Additional error handling
          $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
          $resp = json_decode(curl_exec($req), true);
          curl_close($req);


          $coffeeShop = CoffeeShop::where('user_id', 39)
                                  ->update(['stripe_user_id' => $resp['stripe_user_id'], 
                                            'stripe_access_token' => $resp['access_token'],
                                            'stripe_scope' => $resp['scope'],
                                            'stripe_refresh_token' => $resp['refresh_token'],
                                            'stripe_livemode' => $resp['livemode'],
                                            'stripe_publishable_key' => $resp['stripe_publishable_key']
                                  ]);
          $response = $resp;


        } else if (isset($_GET['error'])) { // Error
          $response = $_GET['error_description'];
        } else {
          $response = '';
        }


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

        $offers = CoffeeShop::whereOfferActivated(true)->get();
        while ($offers->count() < 4) {
            $offers->add(new CoffeeShop());
        }

        $posts = Post::orderBy('created_at', 'desc')->limit(2)->get();

        $agent = new Agent();

        return view('welcome')
            ->with('featuredShops', $featured)
            ->with('posts', $posts)
            ->with('offers', $offers->random(4))
            ->with('agent', $agent)
            ->with('home', true)
            ->with('response', $response);
    }

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShops
     * @param null                                         $query
     *
     * @return \Illuminate\View\View
     */
    public function search($query = null)
    {
        if ($this->request->method() === 'POST') {
            $query = $this->request->get('query');
        }
        $location = $this->request->get('location');
        $baseQuery = $query;
        $lat       = $lng = false;
        if (empty( $query ) && $this->request->has('location')) {
            list( $lat, $lng ) = explode(',', $location);
        }
        $filters = \Input::get('f', []);

        $test = $filters;

        if ($lat === false) {
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
                                      ->where('status', '=', 'published')
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
        }

        if ( ! isset( $shops )) {
            if ($lat !== false || $places['status'] !== 'ZERO_RESULTS') {
                if ($lat === false) {
                    $city = app('places')->getPlace($places['predictions'][0]['place_id'])['result'];

                    $lat = $city['geometry']['location']['lat'];
                    $lng = $city['geometry']['location']['lng'];
                }

                $orderByRaw = 'abs(abs(latitude) - ' . abs($lat) . ') + abs(abs(longitude) - ' . abs($lng) . ') asc';
            } else {
                $city       = ['address_components' => []];
                $orderByRaw = 'name';
            }

            if ( ! empty( $baseQuery )) {
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
                            $query->where('spec_' . $filter, '=', true)->where('status', '=', 'published');
                        }
                    }
                })->where('status', '=', 'published')->orderByRaw($orderByRaw)->paginate(6);
            } else {
                $shops = CoffeeShop::where(function (Builder $query) use ($filters) {
                    foreach ($filters as $filter => $_) {
                        if (in_array($filter, CoffeeShop::getSpecs())) {
                            $query->where('spec_' . $filter, '=', true)->where('status', '=', 'published');
                        }
                    }
                })->where('status', '=', 'published')->orderByRaw($orderByRaw)->paginate(6);
            }

            if ($lat !== false) {
                $position = $lat . ',' . $lng;
                foreach ($shops as $shop) {
                    $shop->setDistance($this->calculDistance($shop->latitude, $shop->longitude, $lat, $lng));
                }
            } else {
                $position = '';
            }
        }

        $shops = $shops->appends([
            'location' => $location,
            'query' => $query,
        ]);

        return view('search.results', compact('shops', 'position', 'lat', 'lng'))
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
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('terms');
    }
    public function coffeeShopContract() 
    {
      return view('coffee_contract');
    }
    /**
     * @return \Illuminate\View\View
     */
    public function termsOfUse()
    {
        return view('terms_use');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function signupfaq()
    {
      return view('faq');
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
