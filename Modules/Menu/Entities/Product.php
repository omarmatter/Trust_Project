<?php

namespace Modules\Menu\Entities;

use App\Traits\ImageableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\CartProduct;
use Modules\Order\Entities\OrderProduct;

class Product extends Model
{
    use HasFactory, ImageableTrait;

    protected $fillable = ['name', 'price', 'category_id', 'description', 'main_image'];

    protected $appends = [
        'image_url',

    ];

    protected static function newFactory()
    {
        return \Modules\Menu\Database\factories\ProductFactory::new();
    }

    function scopeFillter(Builder $builder, Request $request)
    {
        $this->scopePrice($builder, $request->from, $request->to);
        $this->scopeName($builder, $request->name);
        $this->scopeCategory($builder, $request->category_id);
        $this->scopeTopSelling($builder, $request->topSalleing);
        $this->scopeOrder($builder, $request->orderBy);
    }

    function scopePrice(Builder $builder, $from, $to)
    {
        if ($from && $to) {
            $builder->where('price', '>=', $from)->where('price', '<', $to);
        }
    }

    function scopeName(Builder $builder, $name)
    {
        if ($name) {
            $builder->where('name', 'like', '%' . $name . '%');
        }
    }


    function scopeCategory(Builder $builder, $category_id)
    {
        if ($category_id) {
            $builder->where('category_id', request('category_id'));
        }
    }

    function scopeTopSelling(Builder $builder, $topSalling)
    {

        if ($topSalling) {

            $builder->withCount('order_products')
                ->orderBy('order_products_count', 'desc');


//            $builder->whereIn('id' ,function ($query) {
//
//              $query->select('product_id')
//                ->from(function ($q1) {
//                    $q1->select('product_id', DB::raw('COUNT(product_id) as count'))
//                        ->groupBy('product_id')
//                        ->orderBy('count', 'desc')->from('order_products');
//                })->dd();

//            });


        }


//        if ($topSalling) {
//
//             $products_id =[];
//
//             $products =  OrderProduct::with('product')->select('product_id', DB::raw('COUNT(product_id) as count'))
//                 ->groupBy('product_id')
//                 ->orderBy('count', 'desc')
//                 ->take(10)->get();
//
//             foreach ($products as $product){
//                 array_push($products_id,$product['product_id']);
//             }
//             $builder->whereIn('id',$products_id);


//            $builder->Join('order_products', 'products.id', '=', 'order_products.product_id')
//                ->select('*',DB::raw('COUNT(products.id) as count'))
//                ->groupBy('products.id')
//                ->orderBy('count','desc')->take(10);
//

//
        //select *, COUNT(products.id) as count from `products`
        // inner join `order_products` on
        //`products`.`id` = `order_products`.`product_id`
        // group by `products`.`id`
        // order by `count` desc
        // limit 10


//        }
    }

    function scopeInCart(Builder $builder)
    {

        $user = auth('sanctum')->user();
        if ($user)
            $builder->withCount(['cart_products' => function ($query) use ($user) {
                    $query->select('quantity')->whereHas('cart', function ($q) use ($user) {
                    $q->where('user_id', $user->id);

                });
            }]);
    }

    function scopeOrder(Builder $builder, $orderBy)
    {
        if ($orderBy)
            $builder->orderBy('created_at', $orderBy);
    }


    public function category()
    {
        return $this->belongsTo(Categorey::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        if (stripos($this->main_image, 'http') === 0) {
            return $this->main_image;
        }
        return asset('uplode/' . $this->main_image);

    }


    public function cart_products()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }


}
