<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Grade;

class GradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Grade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => Grade::factory(),
            'lft' => $this->faker->randomNumber(),
            'rgt' => $this->faker->randomNumber(),
            'depth' => $this->faker->randomNumber(),
            'name' => $this->faker->name,
            'short_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
