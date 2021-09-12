<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Profile;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'multiple_school' => $this->faker->boolean,
            'short_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'time_start' => $this->faker->regexify('[A-Za-z0-9]{5}'),
            'time_end' => $this->faker->regexify('[A-Za-z0-9]{5}'),
            'duration' => $this->faker->regexify('[A-Za-z0-9]{5}'),
            'order' => $this->faker->numberBetween(-10000, 10000),
            'globaluse' => $this->faker->boolean,
        ];
    }
}
