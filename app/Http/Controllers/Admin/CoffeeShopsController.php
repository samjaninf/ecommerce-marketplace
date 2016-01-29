<?php namespace Koolbeans\Http\Controllers\Admin;

use Illuminate\Mail\Message;
use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Http\Requests\UpdateCoffeeShopRequest;
use Koolbeans\Repositories\CoffeeShopRepository;
use Koolbeans\CoffeeShop;
class CoffeeShopsController extends Controller
{
    /**
     * @var \Koolbeans\Repositories\CoffeeShopRepository
     */
    private $coffeeShopRepository;

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShopRepository
     */
    public function __construct(CoffeeShopRepository $coffeeShopRepository)
    {
        $this->coffeeShopRepository = $coffeeShopRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $shops = CoffeeShop::where('status', '!=', 'deleted')->paginate(15);        $shops = CoffeeShop::where('status', '!=', 'deleted')->paginate(15);

        return view('admin.coffee_shop.index')->with('shops', $shops);
    }

    /**
     * @param int    $id
     * @param string $status
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function review($id, $status)
    {
        if ( ! in_array($status, ['requested', 'accepted', 'published', 'declined'])) {
            return redirect()->back()->with('messages', ['danger' => "Status $status unknown."]);
        }

        $coffeeShop         = $this->coffeeShopRepository->find($id);
        $coffeeShop->status = $status;
        $coffeeShop->save();

        if ($status === 'accepted') {
            \Mail::send('emails.application', ['user' => $coffeeShop->user], function (Message $m) use ($coffeeShop) {
                $m->to($coffeeShop->user->email, $coffeeShop->name)
                  ->subject('Your shop has been accepted!');
            });
        }

        if ($status === 'declined') {
            \Mail::send('emails.coffeeshop_declined', ['user' => $coffeeShop->user], function (Message $m) use ($coffeeShop) {
                $m->to($coffeeShop->user->email, $coffeeShop->name)
                  ->subject('Your shop has been declined!');
            });
        }
        if ($status === 'requested') {
            return redirect()
                ->back()
                ->with('messages', ['info' => "Coffee shop put on hold. You can safely review it."]);
        }

        $next = $this->coffeeShopRepository->findNextApplication($coffeeShop);

        if ($next === null) {
            return redirect(route('admin.home'))->with('messages',
                ['info' => "Coffee shop $status!", 'success' => 'You reviewed all applications!']);
        }

        return redirect(route('admin.coffee-shop.show', ['coffee_shop' => $next]))->with('messages',
            ['info' => "Coffee shop $status!"]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function featured($id)
    {
        $coffeeShop           = $this->coffeeShopRepository->find($id);
        $coffeeShop->featured = ! $coffeeShop->featured;
        $coffeeShop->save();
        $text = $coffeeShop->featured ? 'featured' : 'not featured anymore';

        return redirect()->back()->with('messages', ['info' => "Coffee shop now $text!"]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);

        if ($coffeeShop->status === 'requested') {
            list( $previous, $next ) = $this->coffeeShopRepository->findAdjacentApplications($coffeeShop);
        }

        if (empty( $previous )) {
            $previous = $coffeeShop;
        }

        if (empty( $next )) {
            $next = $coffeeShop;
        }

        return view('admin.coffee_shop.show', [
            'coffeeShop' => $coffeeShop,
            'previous'   => $previous,
            'next'       => $next,
        ]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);

        return view('admin.coffee_shop.edit')->with('coffeeShop', $coffeeShop);
    }

    /**
     * @param \Koolbeans\Http\Requests\UpdateCoffeeShopRequest $request
     * @param int                                              $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCoffeeShopRequest $request, $id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);
        $coffeeShop->update($request->only(['name', 'location', 'postal_code', 'phone_number']));

        return redirect(route('admin.coffee-shop.index'))->with('messages',
            ['info' => "Coffee shop $coffeeShop->name updated!"]);
    }

    public function destroy($id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);
        $coffeeShop->update(['status' => 'denied']);
        $shops = CoffeeShop::where('status', '!=', 'deleted')->paginate(15);
        return view('admin.coffee_shop.index')->with('shops', $shops);
    }
    public function enable($id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);
        $coffeeShop->update(['status' => 'published']);
        
        $shops = CoffeeShop::where('status', '!=', 'deleted')->paginate(15);
        return view('admin.coffee_shop.index')->with('shops', $shops);
    }
    public function delete($id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);
        $coffeeShop->update(['status' => 'deleted']);
        $shops = CoffeeShop::where('status', '!=', 'deleted')->paginate(15);
        return view('admin.coffee_shop.index')->with('shops', $shops);
    }
}
