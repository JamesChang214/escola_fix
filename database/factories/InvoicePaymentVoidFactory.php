<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\InvoicePayment;
use App\Models\InvoicePaymentVoid;
use App\Models\VolidedBy;

class InvoicePaymentVoidFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoicePaymentVoid::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_payment_id' => InvoicePayment::factory(),
            'reason' => $this->faker->word,
            'voided_date' => $this->faker->date(),
            'volided_by' => VolidedBy::factory(),
        ];
    }
}
