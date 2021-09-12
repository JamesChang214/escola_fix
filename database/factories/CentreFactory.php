<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Centre;
use App\Models\User;

class CentreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Centre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'short_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            '2c_name' => $this->faker->regexify('[A-Za-z0-9]{2}'),
            'regno' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'fyending' => $this->faker->date(),
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
            'www' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'contact' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'calendar' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'logo' => $this->faker->regexify('[A-Za-z0-9]{300}'),
            'logo_small' => $this->faker->regexify('[A-Za-z0-9]{300}'),
            'currency' => $this->faker->regexify('[A-Za-z0-9]{3}'),
            'invoice_number_type' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'invoice_number_format' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'receipt_number_format' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'invoice_template' => $this->faker->word,
            'receipt_template' => $this->faker->word,
            'contra_template' => $this->faker->word,
            'refund_template' => $this->faker->word,
            'payment_insturctions1' => $this->faker->text,
            'payment_instructions2' => $this->faker->text,
            'credit_instructions' => $this->faker->text,
            'next_invoice_no' => $this->faker->numberBetween(-10000, 10000),
            'next_adjustment_no' => $this->faker->numberBetween(-10000, 10000),
            'next_receipt_no' => $this->faker->numberBetween(-10000, 10000),
            'next_refund_no' => $this->faker->numberBetween(-10000, 10000),
            'next_contra_no' => $this->faker->numberBetween(-10000, 10000),
            'next_expense_no' => $this->faker->numberBetween(-10000, 10000),
            'next_expense_payment_no' => $this->faker->numberBetween(-10000, 10000),
            'next_claim_no' => $this->faker->numberBetween(-10000, 10000),
            'next_journal_no' => $this->faker->numberBetween(-10000, 10000),
            'cash_on_hand' => $this->faker->randomFloat(2, 0, 99999999.99),
            'created_user_id' => User::factory(),
            'edited_user_id' => User::factory(),
            'deleted_user_id' => User::factory(),
        ];
    }
}
