<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\FunctionalLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FunctionalLocation>
 */
class FunctionalLocationFactory extends Factory
{
    protected $model = FunctionalLocation::class;

    public function definition(): array
    {
        return [
            'code' => 'FL-' . $this->faker->unique()->numerify('######'),
            'serial_no' => null,
            'registration' => null,
            'type' => null,
            'mel' => null,
            'status' => 'Airworthy',
            'maintenance_plan' => null,
            'owner_code' => null,
            'owner_name' => null,
            'operator_code' => null,
            'operator_name' => null,
            'item_id' => null,
        ];
    }
}
