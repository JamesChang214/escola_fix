<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Classer;
use App\Models\FinanceDocument;
use App\Models\FinanceDocumentItem;

class FinanceDocumentItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinanceDocumentItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'finance_document_id' => FinanceDocument::factory(),
            'link_key' => $this->faker->numberBetween(-10000, 10000),
            'link_id' => $this->faker->numberBetween(-10000, 10000),
            'classer_id' => Classer::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'discount_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'tax_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'description' => $this->faker->text,
            'transaction_date' => $this->faker->date(),
            'reference_no' => $this->faker->word,
            'private_note' => $this->faker->text,
            'public_note' => $this->faker->text,
            'account_id' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
