<?php namespace Koolbeans\Http\Controllers;

use Koolbeans\Http\Requests;
use Koolbeans\Repositories\CoffeeShopRepository;

class GalleryImagesController extends Controller
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
     * @param int $coffeeShopId
     *
     * @return \Illuminate\View\View
     */
    public function index($coffeeShopId)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);

        return view('coffee_shop.gallery.index', [
            'coffeeShop' => $coffeeShop,
            'gallery'    => $coffeeShop->gallery()->orderBy('position', 'asc')->get(),
        ]);
    }

    /**
     * @param int $coffeeShopId
     *
     * @return \Illuminate\View\View
     */
    public function create($coffeeShopId)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);

        return view('coffee_shop.gallery.create',
            ['coffeeShop' => $coffeeShop, 'image' => $coffeeShop->gallery()->firstOrNew([])]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);

        $file = \Request::file('image');
        if ($file->isValid()) {
            $destinationPath = $coffeeShop->getUploadPath();
            \Storage::disk('local')->makeDirectory($destinationPath);

            $extension = $file->getClientOriginalExtension();
            $fileName  = date('Y_m_d_His') . '.' . $extension;
            $file->move($destinationPath, $fileName);

            $coffeeShop->gallery()->create([
                'image' => $fileName,
            ]);

            return redirect(route('coffee-shop.gallery.index', ['coffeeShop' => $coffeeShop]));
        }

        return redirect(route('coffee-shop.gallery.create', ['coffeeShop' => $coffeeShop]));
    }

    /**
     * @param $coffeeShopId
     * @param $imageId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($coffeeShopId, $imageId)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
        $image      = $coffeeShop->gallery()->find($imageId);
        \Storage::disk('local')->delete($coffeeShop->getUploadPath() . '/' . $image->image);
        $image->delete();

        return redirect()->back()->with('messages', ['success' => 'Image successfully removed!']);
    }
}
