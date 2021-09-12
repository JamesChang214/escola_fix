<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;

class GuardianFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guardian::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'common_name' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'name_format' => $this->faker->word,
            'student_id' => Student::factory(),
            'address1' => $this->faker->streetAddress,
            'address2' => $this->faker->secondaryAddress,
            'address3' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'address4' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'city' => $this->faker->city,
            'state' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'area_code' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'created_user_id' => User::factory(),
            'edited_user_id' => User::factory(),
            'deleted_user_id' => User::factory(),
        ];
    }
}
