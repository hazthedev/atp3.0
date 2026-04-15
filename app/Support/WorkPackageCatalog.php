<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class WorkPackageCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public static function all(): Collection
    {
        $functionalLocation = FunctionalLocationCatalog::find(1) ?? [];
        $equipment = EquipmentCatalog::find(15) ?? [];

        return collect([
            [
                'id' => '1',
                'code' => 'WP-000001',
                'status' => 'Draft',
                'object_type' => 'Functional Location',
                'object_reference' => $functionalLocation['code'] ?? '9M-WAA',
                'object_fields' => [
                    ['label' => 'Code', 'value' => $functionalLocation['code'] ?? ''],
                    ['label' => 'Serial Number', 'value' => $functionalLocation['serial_no'] ?? ''],
                    ['label' => 'Registration', 'value' => $functionalLocation['registration'] ?? ''],
                    ['label' => 'Type', 'value' => $functionalLocation['type'] ?? ''],
                ],
                'create_date' => '31.03.26',
                'created_by' => 'Planning',
                'update_date' => '31.03.26',
                'updated_by' => 'Planning',
                'comment' => '',
                'linked_equipment' => [
                    ['reference' => 'EQ-001', 'description' => 'AW139 - 9M-WAA'],
                    ['reference' => 'EQ-015', 'description' => 'ACTUATOR,SMA / 3918'],
                ],
                'days' => '',
                'or_date' => '',
                'hours_increment' => '',
                'cycles_increment' => '0.0000',
                'calculate_from_utilization_model' => false,
            ],
            [
                'id' => '2',
                'code' => 'WP-000002',
                'status' => 'Released',
                'object_type' => 'Equipment',
                'object_reference' => ($equipment['equipment_no'] ?? '15') . ' / ' . ($equipment['item_no'] ?? '1-8486-3'),
                'object_fields' => [
                    ['label' => 'Equipment No.', 'value' => $equipment['equipment_no'] ?? $equipment['id'] ?? ''],
                    ['label' => 'Internal S/N', 'value' => $equipment['serial_number'] ?? ''],
                    ['label' => 'Item Code', 'value' => $equipment['item_no'] ?? ''],
                    ['label' => 'Item Description', 'value' => $equipment['item_description'] ?? $equipment['item_name'] ?? ''],
                ],
                'create_date' => '26.03.26',
                'created_by' => 'Engineering',
                'update_date' => '29.03.26',
                'updated_by' => 'Engineering',
                'comment' => '',
                'linked_equipment' => [
                    ['reference' => 'EQ-015', 'description' => 'ACTUATOR,SMA / 3918'],
                ],
                'days' => '',
                'or_date' => '',
                'hours_increment' => '',
                'cycles_increment' => '0.0000',
                'calculate_from_utilization_model' => true,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(int|string|null $id): ?array
    {
        if ($id === null || $id === '') {
            return null;
        }

        return self::all()->firstWhere('id', (string) $id);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public static function search(string $term = ''): Collection
    {
        $needle = mb_strtolower(trim($term));

        if ($needle === '') {
            return self::all()->values();
        }

        return self::all()
            ->filter(function (array $row) use ($needle): bool {
                $haystack = implode(' ', [
                    $row['code'],
                    $row['status'],
                    $row['object_type'],
                    $row['object_reference'],
                ]);

                return mb_stripos($haystack, $needle) !== false;
            })
            ->values();
    }
}
