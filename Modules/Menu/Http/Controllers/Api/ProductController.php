<?php

namespace Modules\Menu\Http\Controllers\Api;

use App\Facades\ImageFacade;
use App\Facades\smsFacade;
use App\Serveices\General\ImageServeice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Menu\Entities\Image;
use Modules\Menu\Entities\Product;
use Modules\Menu\Http\Requests\ProductRequest;
use Modules\Menu\Transformers\ProductCollection;
use Modules\Menu\Transformers\ProductResource;
use Modules\Order\Entities\CartProduct;
use Modules\Order\Entities\OrderProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */

    public function __construct()
    {
        $this->middleware(['auth:sanctum','isAdmin'])->except('index');
    }

    public function index(Request $request)
    {

        $products= Product::InCart()->with('images')->Fillter($request)->paginate(100);
//        return $products;
         return coustom_response(true, 'All Product', [
            'products' => ProductResource::collection($products),
            'pagination' => $this->paginate($products)

        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
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


//        $file = $request->file('main_image');
//        $image_path = $fil$data = $request->validated()e->store('/', 'uplode');
//        ;
//        $data['main_image'] = $image_path;
//        $product = Product::create($data);
//
//        if ($request->hasFile('image')) {
//            $file = $request->file('image');
//            foreach ($file as $img) {
//
//                $image_path = $img->store('/', 'uplode');
//
//
//                $product->images()->create(['image' => $image_path]);
//            }


//        foreach ($request->image_path as $imag) {
//
//            Image::create([
//                'image_path' => $imag,
//                'product_id' => $product->id,
//                'image_type' => $request->image_type,
//            ]);
//
//        }

        return coustom_response(true, 'success add Product', []);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return coustom_response(true, 'success delete Product',[], 200);

    }

    public function fillter(Request $request)
    {
        $products = Product::with('category')->with('images')->Fillter($request);

//        if ($request->category_id) {
//            $products = $products->whereHas('category', function ($query) {
//                $query->where('id', request('category_id'));
//            });
//        };
//
//        if ($request->from && $request->to) {
//            $products = $products->where('price', '>=', $request->from)->where('price', '<', $request->to);
//        };
//        if ($request->name){
//            $products = $products->where('name','=',$request->name);
//        }
        return coustom_response(true, 'Fillter Product', ProductResource::collection($products->get()), 200);


    }
}
