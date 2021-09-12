<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Centre;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\User;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_number' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'centre_id' => Centre::factory(),
            'student_id' => Student::factory(),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'revenue_start_date' => $this->faker->date(),
            'revenue_end_date' => $this->faker->date(),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'discount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'adjustment' => $this->faker->randomFloat(2, 0, 99999999.99),
            'tax' => $this->faker->randomFloat(2, 0, 99999999.99),
            'balance' => $this->faker->randomFloat(2, 0, 99999999.99),
            'name' => $this->faker->name,
            'address1' => $this->faker->streetAddress,
            'address2' => $this->faker->secondaryAddress,
            'address3' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'address4' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'postal_code' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'printed_date' => $this->faker->date(),
            'emailed_date' => $this->faker->date(),
            'instructions_1' => $this->faker->text,
            'instructions_2' => $this->faker->text,
            'instructions_3' => $this->faker->text,
            'instructions_4' => $this->faker->text,
            'invoice_header' => $this->faker->text,
            'invoice_footer' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'invoice_template' => $this->faker->word,
            'private_note' => $this->faker->word,
            'public_note' => $this->faker->word,
            'status' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'source' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'created_user_id' => User::factory(),
            'edited_user_id' => User::factory(),
            'deleted_user_id' => User::factory(),
        ];
    }
}
