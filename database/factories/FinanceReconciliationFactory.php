<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FinanceReconciliation;
use App\Models\User;

class FinanceReconciliationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinanceReconciliation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'link_key' => $this->faker->numberBetween(-10000, 10000),
            'link_id' => $this->faker->numberBetween(-10000, 10000),
            'cleared_date' => $this->faker->date(),
            'user_id' => User::factory(),
        ];
    }
}
