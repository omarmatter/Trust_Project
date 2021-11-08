<?php

namespace Modules\Menu\Repository;

use App\Facades\ImageFacade;
use Illuminate\Http\Request;
use Modules\Menu\Entities\Product;

class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return Product::InCart()->with('images')->Fillter($request)->paginate(100);
    }

    /**
     * @return mixed
     */
    public function store(Request  $request)
    {
        $product = Product::create($request->validated());
        $imageData = ImageFacade::uplodeImage($request->main_image);
        $imageData['is_main'] = '1';
        $product->images()->create($imageData);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $imageData = ImageFacade::uplodeImage($image);
                $product->images()->create($imageData);
            }
        }

    }

    /**
     * @return mixed
     */
    public function update(Request $request ,$id)
    {
        $product=Product::findOrFail($id);
        $product->update($request->validated());
        if ($request->has('main_image')) {
            $imageData = ImageFacade::uplodeImage($request->main_image);
            $imageData['is_main'] = '1';
            $product->images()->create($imageData);

        }
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        // TODO: Implement destroy() method.
    }
}
