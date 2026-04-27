<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CounterRef;
use App\Models\FunctionalLocation;
use App\Models\FunctionalLocationCounter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FunctionalLocationCounter>
 */
class FunctionalLocationCounterFactory extends Factory
{
    protected $model = FunctionalLocationCounter::class;

    public function definition(): array
    {
        return [
            'functional_location_id' => FunctionalLocation::factory(),
            'counter_ref_id' => CounterRef::factory(),
            'value_dec' => 0,
            'reading_hour' => '00:00',
            'propagate' => true,
            'is_used' => true,
        ];
    }
}
