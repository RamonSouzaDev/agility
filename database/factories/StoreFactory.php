<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'cep' => $this->faker->postcode,
            'street' => $this->faker->streetAddress,
            'neighborhood' => $this->faker->city,
            'city' => $this->faker->city,
        ];
    }
}
