<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Classer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Invoicefeetype;
use App\Models\Student;
use App\Models\User;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

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
            'invoice_fee_type_id' => Invoicefeetype::factory(),
            'revenue_start_date' => $this->faker->date(),
            'revenue_end_date' => $this->faker->date(),
            'syear' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'classer_id' => Classer::factory(),
            'description' => $this->faker->text,
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'discount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'tax' => $this->faker->randomFloat(2, 0, 99999999.99),
            'comment' => $this->faker->word,
            'order' => $this->faker->numberBetween(-10000, 10000),
            'created_user_id' => User::factory(),
            'edited_user_id' => User::factory(),
            'deleted_user_id' => User::factory(),
        ];
    }
}
