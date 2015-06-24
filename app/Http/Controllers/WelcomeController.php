<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Koolbeans\CoffeeShop;
use Koolbeans\MobileToken;
use Koolbeans\Offer;
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

        $shops    = CoffeeShop::where('location', 'like', $query)
                              ->orWhere('county', 'like', $query)
                              ->orderByRaw($orderByRaw)
                              ->paginate(8);
        $position = $city['geometry']['location']['lat'] . ',' . $city['geometry']['location']['lng'];

        return view('search.results', compact('shops', 'position'))->with('query', $baseQuery);
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
        return view('contact');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact()
    {
        return redirect()->back()->with('messages', ['success' => 'Your message have been sent.']);
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
        if ($request->has('unregister')) {
            $requestTokens =
                $request->has('_push.ios_token') ? $request->get('_push.ios_token') : $request->get('_push.android_token');
            $user->mobile_tokens()->whereTokenIn($requestTokens)->delete();

            return;
        }

        if ($request->has('_push')) {
            $requestTokens =
                $request->has('_push.ios_token') ? $request->get('_push.ios_token') : $request->get('_push.android_token');
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
