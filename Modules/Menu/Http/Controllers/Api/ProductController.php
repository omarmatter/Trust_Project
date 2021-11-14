<?php

namespace Modules\Menu\Http\Controllers\Api;

use App\Facades\ImageFacade;
use App\Facades\smsFacade;
use App\Http\Controllers\Controller;
use App\Serveices\General\ImageServeice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Menu\Entities\Image;
use Modules\Menu\Entities\Product;
use Modules\Menu\Exports\ProductsExport;
use Modules\Menu\Http\Requests\ProductRequest;
use Modules\Menu\Repository\ProductRepositoryInterface;
use Modules\Menu\Transformers\ProductCollection;
use Modules\Menu\Transformers\ProductResource;
use Modules\Order\Entities\CartProduct;
use Modules\Order\Entities\OrderProduct;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
protected  $product;
    public function __construct(ProductRepositoryInterface $product)
    {
        $this->middleware(['auth:sanctum','isAdmin'])->except(['index','export']);
        $this->product=$product;
    }

    public function index(Request $request)
    {

        $products= $this->product->index($request);


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


      $this->product->store($request);
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
    public function update(ProductRequest $request, $id)
    {

             $this->product->update($request,$id);


        return coustom_response(true, 'update add Product', []);


    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
      $this->product->destroy($id);
        return coustom_response(true, 'success delete Product',[], 200);

    }

    public function export()
    {
        return Excel::download(new ProductsExport(), 'Products.xlsx');
    }
}
