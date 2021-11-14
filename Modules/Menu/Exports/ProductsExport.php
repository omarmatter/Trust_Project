<?php

namespace Modules\Menu\Exports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Menu\Entities\Product;
use Modules\Menu\Repository\ProductRepositoryInterface;

class ProductsExport implements   FromCollection, WithMapping, WithHeadings
{

    /**
     * @return Collection
     */
    public function collection()
    {
        // TODO: Implement collection() method.
        return  Product::with('category')->get();
    }

    public function map($products) : array {
        return [
            $products->id,
            $products->category->name,
            $products->name,
            $products->price,

        ] ;


    }
    public function headings() : array {
        return [
            '#',
            'category',
            'name',
            'Price',

        ] ;
    }
}
