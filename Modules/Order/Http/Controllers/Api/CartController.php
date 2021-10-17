<?php

namespace Modules\Order\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Cart;
use Modules\Order\Http\Requests\StoreCartRequest;
use Modules\Order\Transformers\cartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->with('product')->get();

        return coustom_response(true, 'All Cart', cartResource::collection($carts));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCartRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::user()->id;
        $data['user_id'] = $userId;
        $qu = DB::table('carts')
            ->where('product_id', $request->product_id)
            ->value('quantity');
        $data['quantity'] = $qu + $data['quantity'];
        Cart::updateOrCreate(['user_id' => $data['user_id'],
            'product_id' => $data['product_id']
        ], $data);

        return coustom_response(true, 'add success to cart', [], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $cart = Cart::findOrFail($id);
        return coustom_response(true, 'cart', new cartResource($cart), 200);
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
        $cart = Cart::findOrFail($id)->delete();
        return coustom_response(true, 'success delete', []);
    }
}
