<?php
namespace Modules\Menu\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Menu\Entities\Categorey;
use Modules\Menu\Entities\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        $category = Categorey::inRandomOrder()
            ->limit(1)
            ->first(['id']);
        return [
            'name' =>$this->faker->name,
            'price'=>$this->faker->numberBetween(50,200),
            'description'=>$this->faker->text ,
            'category_id'=>$category->id
        ];
    }
}

