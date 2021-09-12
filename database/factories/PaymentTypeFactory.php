<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Centre;
use App\Models\PaymentType;

class PaymentTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'short_name' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'centre_id' => Centre::factory(),
            'processing_fee' => $this->faker->randomFloat(2, 0, 99999999.99),
            'processing_percentage' => $this->faker->randomFloat(2, 0, 99999999.99),
            'is_usable' => $this->faker->word,
            'account_id' => $this->faker->numberBetween(-10000, 10000),
            'globaluse' => $this->faker->boolean,
        ];
    }
}
