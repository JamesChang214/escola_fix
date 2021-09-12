<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Centre;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\PaymentType;
use App\Models\Student;
use App\Models\User;

class InvoicePaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoicePayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => Invoice::factory(),
            'student_id' => Student::factory(),
            'centre_id' => Centre::factory(),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'receipt_number' => $this->faker->word,
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'payment_type_id' => PaymentType::factory(),
            'private_note' => $this->faker->text,
            'public_note' => $this->faker->text,
            'cheuque_number' => $this->faker->regexify('[A-Za-z0-9]{128}'),
            'bank_name' => $this->faker->regexify('[A-Za-z0-9]{128}'),
            'cleared' => $this->faker->word,
            'cleared_date' => $this->faker->date(),
            'user_id' => User::factory(),
            'status' => $this->faker->word,
            'source' => $this->faker->word,
        ];
    }
}
