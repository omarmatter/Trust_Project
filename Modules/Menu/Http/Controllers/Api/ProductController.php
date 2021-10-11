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
        $products = Product::paginate(100);
        return  coustom_response(true,'All Product',new ProductCollection($products),200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        $product= Product::create( $request->validated());

        foreach ($request->image_path as $imag){

            Image::create([
                'image_path'=>$imag,
                'product_id'=>$product->id,
                'image_type' =>$request->image_type,
            ]);

        }

        return coustom_response(true, 'success add Product',[]);
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

    public  function  fillter(Request  $request){
        $products = Product::price($request->from , $request->to)->paginate(50);
        return coustom_response(true,'Fillter Product',new ProductCollection($products),200);




    }
}
