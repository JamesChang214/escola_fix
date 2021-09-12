<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Centre;
use App\Models\Grade;
use App\Models\School;
use App\Models\Student;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'last_name' => $this->faker->lastName,
            'common_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'name_format' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'gender' => $this->faker->word,
            'dob' => $this->faker->date(),
            'ethnicity' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'language' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'identification' => $this->faker->word,
            'school_id' => School::factory(),
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
            'avatar' => $this->faker->word,
            'enrollment_date' => $this->faker->date(),
            'source' => $this->faker->word,
            'grade_id' => Grade::factory(),
            'status' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'centre_id' => Centre::factory(),
        ];
    }
}
