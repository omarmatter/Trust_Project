<?php

namespace Modules\Menu\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Categorey;
use Modules\Menu\Http\Requests\CategoreyRequest;
use Modules\Menu\Transformers\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categoreis = Categorey::paginate(100);
        return  coustom_response(true,'All Categoreis',[
            'Categories'=> CategoryResource::collection($categoreis),
            $this->paginate($categoreis)
            ]

            ,200);

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CategoreyRequest $request)
    {
        Categorey::create( $request->validated());
        return coustom_response(true, 'success add Categorey',[]);
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
}
