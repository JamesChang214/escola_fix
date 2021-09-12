<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Centre;
use App\Models\FinanceDocument;
use App\Models\Student;
use App\Models\User;

class FinanceDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinanceDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->word,
            'link_key' => $this->faker->numberBetween(-10000, 10000),
            'link_id' => $this->faker->numberBetween(-10000, 10000),
            'centre_id' => Centre::factory(),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'vendor_id' => $this->faker->numberBetween(-10000, 10000),
            'student_id' => Student::factory(),
            'document_no' => $this->faker->word,
            'discount_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'tax_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total_discount_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total_tax_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'reason' => $this->faker->word,
            'source' => $this->faker->word,
            'status' => $this->faker->word,
            'transaction_payee' => $this->faker->word,
            'transaction_type_id' => $this->faker->numberBetween(-10000, 10000),
            'transaction_doc_no' => $this->faker->word,
            'transaction_date' => $this->faker->date(),
            'private_note' => $this->faker->text,
            'public_note' => $this->faker->text,
            'user_id' => User::factory(),
            'cleared_date' => $this->faker->dateTime(),
        ];
    }
}
