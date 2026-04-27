<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CounterRef;
use App\Models\Equipment;
use App\Models\EquipmentCounter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EquipmentCounter>
 */
class EquipmentCounterFactory extends Factory
{
    protected $model = EquipmentCounter::class;

    public function definition(): array
    {
        return [
            'equipment_id' => Equipment::factory(),
            'counter_ref_id' => CounterRef::factory(),
            'value_dec' => 0,
            'reading_hour' => '00:00',
            'propagate' => true,
            'is_used' => true,
        ];
    }
}
