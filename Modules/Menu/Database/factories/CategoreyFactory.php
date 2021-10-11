<?php
namespace Modules\Menu\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Menu\Entities\Categorey;

class CategoreyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Categorey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name
        ];
    }
}

