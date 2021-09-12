<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Grade;
use App\Models\InvoiceFeeType;

class InvoiceFeeTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceFeeType::class;

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
            'grade_id' => Grade::factory(),
            'sort_order' => $this->faker->numberBetween(-10000, 10000),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'taxable' => $this->faker->boolean,
            'tax_percentage' => $this->faker->numberBetween(-10000, 10000),
            'revenue_start_date' => $this->faker->date(),
            'revenue_end_date' => $this->faker->date(),
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'usable_start_date' => $this->faker->date(),
            'usable_end_date' => $this->faker->date(),
            'globaluse' => $this->faker->boolean,
            'is_usable' => $this->faker->word,
            'is_refundable' => $this->faker->boolean,
            'account_id' => $this->faker->numberBetween(-10000, 10000),
            'payment_instructions' => $this->faker->text,
            'small_print' => $this->faker->text,
        ];
    }
}
