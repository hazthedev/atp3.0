<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'code' => 'ITM-' . $this->faker->unique()->numerify('######'),
            'description' => $this->faker->sentence(3),
            'in_stock' => 0,
            'manufacturer' => null,
            'item_class' => null,
            'calibration' => null,
            'shelf_life' => null,
            'sales_item' => 'Yes',
            'manage_by_batch_serial' => 'Yes',
            'inventory_item' => 'Yes',
            'purchase_item' => 'Yes',
            'item_group' => null,
            'uom_group' => 'Manual',
            'alternative_part' => null,
            'serial_no_management' => 'No',
            'item_type' => 'Items',
        ];
    }
}
