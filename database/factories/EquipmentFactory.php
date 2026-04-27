<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipment>
 */
class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        return [
            'equipment_no' => 'EQ-' . $this->faker->unique()->numerify('######'),
            'serial_number' => 'SN-' . $this->faker->unique()->numerify('######'),
            'item_id' => Item::factory(),
            'category_part' => null,
            'variant' => null,
            'status' => 'On Aircraft',
            'owner_code' => null,
            'owner_name' => null,
            'operator_code' => null,
            'operator_name' => null,
            'maintenance_plan' => null,
            'mel' => null,
            'chapter' => null,
            'section' => null,
            'subject' => null,
            'sheet' => null,
            'mark' => null,
            'mel_item' => null,
        ];
    }
}
