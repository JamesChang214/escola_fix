<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Classertemplate;
use App\Models\Grade;

class ClassertemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classertemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'subject' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'course' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'grade_id' => Grade::factory(),
            'seats' => $this->faker->numberBetween(-10000, 10000),
            'period' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'graded' => $this->faker->boolean,
            'published' => $this->faker->boolean,
            'attendance' => $this->faker->boolean,
            'location' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'credits' => $this->faker->numberBetween(-10000, 10000),
            'format' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'lesson_price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'material' => $this->faker->randomFloat(2, 0, 99999999.99),
            'registration' => $this->faker->randomFloat(2, 0, 99999999.99),
            'globaluse' => $this->faker->word,
        ];
    }
}
