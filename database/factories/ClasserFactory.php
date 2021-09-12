<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Centre;
use App\Models\Classer;
use App\Models\Classertemplate;
use App\Models\Grade;
use App\Models\Period;
use App\Models\User;

class ClasserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'classertemplate_id' => Classertemplate::factory(),
            'centre_id' => Centre::factory(),
            'name' => $this->faker->name,
            'short_name' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'subject' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'grade_id' => Grade::factory(),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'period_id' => Period::factory(),
            'location' => $this->faker->regexify('[A-Za-z0-9]{1}'),
            'days' => $this->faker->regexify('[A-Za-z0-9]{1}'),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'credits' => $this->faker->numberBetween(-10000, 10000),
            'seats' => $this->faker->numberBetween(-10000, 10000),
            'seats_avail' => $this->faker->numberBetween(-10000, 10000),
            'graded' => $this->faker->boolean,
            'attendance' => $this->faker->boolean,
            'published' => $this->faker->boolean,
            'created_user_id' => User::factory(),
            'edited_user_id' => User::factory(),
            'deleted_user_id' => User::factory(),
        ];
    }
}
