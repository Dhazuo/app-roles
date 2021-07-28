<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'image' => $this->faker->imageUrl(1280, 720),
            'name' => $this->faker->name,
            'description' => $this->faker->text(200),
            'price' => $this->faker->numberBetween(200, 3000),
            'stock' => $this->faker->numberBetween(0, 100)
        ];
    }
}
