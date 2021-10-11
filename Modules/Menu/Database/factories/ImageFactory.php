<?php
namespace Modules\Menu\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Entities\Product;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Entities\Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $Product = Product::inRandomOrder()
            ->limit(1)
            ->first(['id']);
        return [
            'image_type' =>$this->faker->randomElement(['product']),
            'image_path'=>$this->faker->imageUrl,
            'product_id'=>$Product->id
        ];
    }
}

