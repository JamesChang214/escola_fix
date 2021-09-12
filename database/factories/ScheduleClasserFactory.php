<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Classer;
use App\Models\ScheduleClasser;
use App\Models\Student;
use App\Models\User;

class ScheduleClasserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScheduleClasser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_id' => Student::factory(),
            'classer_id' => Classer::factory(),
            'enrollment_date' => $this->faker->date(),
            'withdrawl_date' => $this->faker->date(),
            'reason' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'created_user_id' => User::factory(),
            'edited_user_id' => User::factory(),
            'deleted_user_id' => User::factory(),
        ];
    }
}
