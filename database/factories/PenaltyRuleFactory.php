<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CounterRef;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PenaltyRule>
 */
class PenaltyRuleFactory extends Factory
{
    protected $model = PenaltyRule::class;

    public function definition(): array
    {
        return [
            'penalty_id' => Penalty::factory(),
            'subject_type' => 'item',
            'subject_id' => 1,
            'target_item_id' => null,
            'monitoring_counter_ref_id' => CounterRef::factory(),
            'rate_value' => 0,
            'rate_counter_ref_id' => null,
            'static_value' => 0,
            'static_counter_ref_id' => null,
            'is_active' => true,
        ];
    }
}
