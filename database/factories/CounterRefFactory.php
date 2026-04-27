<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CounterRef;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CounterRef>
 */
class CounterRefFactory extends Factory
{
    protected $model = CounterRef::class;

    public function definition(): array
    {
        return [
            'code' => 'CR-' . $this->faker->unique()->numerify('######'),
            'name' => $this->faker->word(),
            'status' => 'Validate',
            'measure_unit' => null,
            'orange_light_limit' => 90,
        ];
    }
}
