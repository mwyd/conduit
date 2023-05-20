<?php

namespace Database\Factories;

use App\Models\SteamMarketCsgoItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SteamMarketCsgoItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = SteamMarketCsgoItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hash_name' => $this->faker->unique()->words(3, true),
            'volume' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'icon' => Str::random(64),
            'icon_large' => Str::random(64),
            'is_stattrak' => $this->faker->numberBetween(0, 1),
            'is_souvenir' => $this->faker->numberBetween(0, 1),
            'name' => $this->faker->words(2, true),
            'name_color' => $this->faker->hexColor(),
            'exterior' => null,
            'phase' => null,
            'collection' => null,
            'type' => $this->faker->words(3, true),
            'type_color' => $this->faker->hexColor(),
        ];
    }
}
