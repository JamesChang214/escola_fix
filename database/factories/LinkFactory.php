<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Link;

class LinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Link::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_type' => $this->faker->word,
            'link_key' => $this->faker->numberBetween(-10000, 10000),
            'link_id' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
