<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class ModificationCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    public static function all(): Collection
    {
        return collect([
            ['id' => '1', 'type' => 'AW139 SB', 'unique_ref' => 'AW139 SB 13-139-429', 'reference' => '13-139-429', 'revision' => 'A', 'title' => 'WEIGHT EXTENSION 7000 KG'],
            ['id' => '2', 'type' => 'BT', 'unique_ref' => 'BT 139-465', 'reference' => '139-465', 'revision' => '', 'title' => 'Tail rotor drive shaft (TRDS) inspection program'],
            ['id' => '3', 'type' => 'BT', 'unique_ref' => 'BT 139-467', 'reference' => '139-467', 'revision' => '', 'title' => 'Tail rotor drive line (TRDL) bearing replacement'],
            ['id' => '4', 'type' => 'BT', 'unique_ref' => 'BT 139-435', 'reference' => '139-435', 'revision' => '', 'title' => 'Display installation update for cockpit indicator panel'],
            ['id' => '5', 'type' => 'BT', 'unique_ref' => 'BT 139-460', 'reference' => '139-460', 'revision' => '', 'title' => 'Breeze rescue hoist extended cable installation'],
            ['id' => '6', 'type' => 'BT', 'unique_ref' => 'BT 139-466', 'reference' => '139-466', 'revision' => '', 'title' => 'MAIN ROTOR (MR) SERVO ACTUATOR software embodiment'],
            ['id' => '7', 'type' => 'BT', 'unique_ref' => 'BT 139-470', 'reference' => '139-470', 'revision' => '', 'title' => 'Tail/rear fuselage attachment fitting reinforcement'],
            ['id' => '8', 'type' => 'BT', 'unique_ref' => 'BT 139-287', 'reference' => '139-287', 'revision' => '', 'title' => 'USB variant mission data upload provision'],
            ['id' => '9', 'type' => 'BT', 'unique_ref' => 'BT 139-452 RA', 'reference' => '139-452 RA', 'revision' => '', 'title' => 'Main rotor (MR) damper body replacement campaign'],
            ['id' => '10', 'type' => 'BT', 'unique_ref' => 'BT 139-450 RI', 'reference' => '139-450 RB', 'revision' => '', 'title' => 'Main Rotor (MR) Damper Inspection standardization'],
        ]);
    }

    /**
     * @return array<string, string>|null
     */
    public static function find(int|string|null $id): ?array
    {
        if ($id === null || $id === '') {
            return null;
        }

        return self::all()->firstWhere('id', (string) $id);
    }
}
