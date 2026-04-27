<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Penalty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penalty>
 */
class PenaltyFactory extends Factory
{
    protected $model = Penalty::class;

    public function definition(): array
    {
        return [
            'code' => 'PEN-' . $this->faker->unique()->numerify('######'),
            'name' => $this->faker->sentence(2),
            'description' => null,
            'is_active' => true,
        ];
    }
}
