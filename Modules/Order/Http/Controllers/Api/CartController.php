<?php

namespace Modules\Order\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Cart;
use Modules\Order\Entities\CartProduct;
use Modules\Order\Http\Requests\StoreCartRequest;
use Modules\Order\Transformers\CartProductResource;
use Modules\Order\Transformers\cartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $cart= Auth::user()->cart->withCount('cart_products')->get();
//        return  $cart;

//        ->cart_products;
//        $carts = Cart::where('user_id', Auth::user()->id)->with('cart_products')->get();

        return coustom_response(true, 'All Cart', cartResource::collection($cart));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCartRequest $request)
    {
        $user_id =Auth::id();
        $data = $request->validated();

         $cart=  Cart::where('user_id',$user_id)->first();
            if(!$cart){
             $cart=   Cart::create(['user_id' =>$user_id]);
            }

            $data['cart_id'] =$cart->id;
        $qu =  CartProduct::where('product_id', $request->product_id)->value('quantity');

        $data['quantity'] = $qu + $data['quantity'] ;
            CartProduct::updateOrCreate(['cart_id' => $cart->id,
            'product_id' => $data['product_id']
        ], $data);

        return coustom_response(true, 'add success to cart', [], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
//    public function show($id)
//    {
//        $cart = Cart::with('cart_products')->findOrFail($id);
//        return coustom_response(true, 'cart', new cartResource($cart), 200);
//    }

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
    public function destroy()
    {
        Auth::user()->cart()->delete();

//        $cart = Cart::findOrFail($id)->delete();
        return coustom_response(true, 'success delete', []);
    }
}
