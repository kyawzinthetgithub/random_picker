<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Winner;

class WinnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Winner::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->word(),
            'customer_phone' => $this->faker->word(),
            'customer_address' => $this->faker->text(),
            'product_name' => $this->faker->word(),
            'product_details' => $this->faker->text(),
        ];
    }
}
