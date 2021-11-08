<?php

namespace Modules\Menu\Repository;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{

    public function index(Request $request);

    public function store(Request $request);

    public function update(Request $request ,$id);

    public function destroy($id);
}
