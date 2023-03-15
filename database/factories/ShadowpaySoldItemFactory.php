<?php

namespace Database\Factories;

use App\Models\ShadowpaySoldItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShadowpaySoldItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = ShadowpaySoldItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => $this->faker->unique()->bothify('??#???####????##'),
            'hash_name' => $this->faker->words(3, true),
            'suggested_price' => $this->faker->randomFloat(2, 1, 100),
            'steam_price' => $this->faker->randomFloat(2, 1, 100),
            'discount' => $this->faker->numberBetween(0, 100),
            'sold_at' => date('Y-m-d H:i:s')
        ];
    }
}
