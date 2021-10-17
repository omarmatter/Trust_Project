<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Entities\order;
use Modules\Order\Http\Requests\OrdertRequest;
use Modules\Order\Transformers\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $orders = order::with('product')->where('user_id', Auth::user()->id)->get();

        return coustom_response(true, 'All orders', OrderResource::collection($orders));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(OrdertRequest $request)
    {
        $userId = Auth::user()->id;
        $data = $request->validated();
        $data['user_id'] = $userId;
        order::updateOrCreate([
                'user_id' => $data['user_id'],
                'product_id' => $data['product_id']
            ]
            , $data
        );
        return coustom_response(true, 'success order', []);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $order = order::findOrFail($id);

        return coustom_response(true, 'order',  new OrderResource($order));
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
        order::findOrFail($id)->delete();

        return coustom_response(true, 'delete success', []);
    }
}
