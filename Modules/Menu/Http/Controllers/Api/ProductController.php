<?php

namespace Modules\Menu\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Image;
use Modules\Menu\Entities\Product;
use Modules\Menu\Http\Requests\ProductRequest;
use Modules\Menu\Transformers\ProductCollection;
use Modules\Menu\Transformers\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $products = Product::with('category')->paginate(100);
        return coustom_response(true, 'All Product', [
            'products' => ProductResource::collection($products),
            $this->paginate($products)

        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        $file = $request->file('main_image');
        $image_path = $file->store('/', 'uplode');
        $data = $request->validated();
        $data['main_image'] = $image_path;
        $product = Product::create($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            foreach ($file as $img){

                $image_path = $img->store('/', 'uplode');


                 $product->images()->create(['image'=>$image_path]);
            }

        }
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
        //
    }

    public function fillter(Request $request)
    {
        $products = Product::with('category')->with('images');

        if ($request->category_id) {
            $products = $products->whereHas('category', function ($query) {
                $query->where('id', request('category_id'));
            });
        };

        if ($request->from && $request->to) {
            $products = $products->where('price', '>=', $request->from)->where('price', '<', $request->to);
        };
        if ($request->name){
            $products = $products->where('name','=',$request->name);
        }
        return coustom_response(true, 'Fillter Product',  ProductResource::collection($products->get()), 200);


    }
}