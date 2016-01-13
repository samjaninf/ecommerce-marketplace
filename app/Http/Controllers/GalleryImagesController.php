<?php namespace Koolbeans\Http\Controllers;

use Koolbeans\Http\Requests;
use Koolbeans\Http\Requests\UploadFileRequest;
use Koolbeans\Repositories\CoffeeShopRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param \Koolbeans\Http\Requests\UploadFileRequest $request
     * @param int                                        $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UploadFileRequest $request, $id)
    {
        $coffeeShop = $this->coffeeShopRepository->find($id);

        $images = $coffeeShop->gallery()->get();

        if(count($images) >= 4) {
            exit;
        }

        $file = $request->file('image');
        if ($file->isValid()) {
            $destinationPath = $coffeeShop->getUploadPath();
            \Storage::disk('local')->makeDirectory($destinationPath);

            $extension = $file->getClientOriginalExtension();
            $fileName  = date('Y_m_d_His') . '.' . $extension;
            $file->move($destinationPath, $fileName);

            $last = $coffeeShop->gallery()->orderBy('position', 'desc')->first();
            $coffeeShop->gallery()->create([
                'image'    => $fileName,
                'position' => $last === null ? 1 : ( $last->position + 1 ),
            ]);

            return redirect(route('coffee-shop.gallery.index', ['coffeeShop' => $coffeeShop]))->with('messages',
                ['success' => 'Your image has been uploaded!']);
        }

        return redirect(route('coffee-shop.gallery.create', ['coffeeShop' => $coffeeShop]))->with('messages',
            ['danger' => 'Your image is not valid.']);
    }

    /**
     * @param $coffeeShopId
     * @param $imageId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveUp($coffeeShopId, $imageId)
    {
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
        $image      = $coffeeShop->gallery()->find($imageId);

        if ($image->position !== 1) {
            $image->position = 1;
            $prev = $coffeeShop->gallery()->wherePosition($image->position)->first();
            $prev->position++;
            $prev->save();
            $image->save();
        }

        return redirect()->back()->with('messages', ['success' => 'Image moved up!']);
    }

    /**
     * @param $coffeeShopId
     * @param $imageId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveDown($coffeeShopId, $imageId)
    {
        throw new NotFoundHttpException();
        $coffeeShop = $this->coffeeShopRepository->find($coffeeShopId);
        $image      = $coffeeShop->gallery()->find($imageId);
        $last       = $coffeeShop->gallery()->orderBy('position', 'desc')->first();

        if ($image->position !== $last->position) {
            $image->position++;
            $next = $coffeeShop->gallery()->wherePosition($image->position)->first();
            $next->position--;
            $image->save();
            $next->save();
        }

        return redirect()->back()->with('messages', ['success' => 'Image moved down!']);
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
