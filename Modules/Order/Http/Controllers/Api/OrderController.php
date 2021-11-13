<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Menu\Entities\Product;
use Modules\Order\Entities\Cart;
use Modules\Order\Entities\order;
use Modules\Order\Entities\OrderProduct;
use Modules\Order\Http\Requests\OrdertRequest;
use Modules\Order\Notifications\ChangeStatusNotification;
use Modules\Order\Transformers\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $orders = Auth::user()->orders()->with('order_method')->with('order_product.product')->get();

        return coustom_response(true, 'All orders', OrderResource::collection($orders));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(OrdertRequest $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return coustom_response(true, 'not found cart', []);
        }
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $cart_products = $cart->cart_products()->get();
            $data['price'] = 0;
            $order = order::create($data);

            $total_price = 0;

            foreach ($cart_products as $cart_product) {

                $total_price += $cart_product->product->price * $cart_product->quantity;
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $cart_product->product_id,
                    'quantity' => $cart_product->quantity,

                ]);
            }
            $order->price = $total_price;
            $order->save();
            Auth::user()->cart()->delete();
            DB::commit();
            return coustom_response(true, 'success order', []);
        } catch (Throwable $ex) {
            DB::rollback();
            throw $ex;

        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $order = order::findOrFail($id)->with('order_product')->get();
        return $order;

        return coustom_response(true, 'order', new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $order= order::findOrFail($id);

         $order->update(['status'=>$request->status]);

        return coustom_response(true, 'success update order', []);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        order::findOrFail($id)->delete();

        return coustom_response(true, 'delete success', []);
    }

    public function how_many_orders(Request $request)
    {
        $orderCount = Auth::user()->orders()->select(
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as Date "),
            DB::raw('COUNT(id) as count'))
            ->where('created_at', '>=', $request->from)
            ->where('created_at', '<=', $request->to)
            ->groupBy('Date')->get();


        return coustom_response(true, 'Order Count', $orderCount);

    }

    public function AllOrder(){
        $orders =order::all();
        return coustom_response(true, 'All orders',[
           'orders'=> OrderResource::collection($orders)]);

    }
}
