<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class MinimumEquipmentListCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    public static function lookupRows(): Collection
    {
        return collect([
            [
                'id' => '1',
                'code' => 'MEL-AW139-001',
                'equipment_code' => '1',
                'fl_code' => '9M-WAA',
                'serial_number' => '31324',
                'registration' => 'M104-04',
                'type' => 'AW139',
                'internal_sn' => '31324',
                'item_code' => 'AW139',
                'variant' => 'AW139',
                'mmel' => 'AW139-MMEL',
                'title' => 'AW139 Operational Minimum Equipment List',
            ],
            [
                'id' => '2',
                'code' => 'MEL-AW139-002',
                'equipment_code' => '15',
                'fl_code' => '9M-WAO',
                'serial_number' => '31419',
                'registration' => '9M-WAO',
                'type' => 'AW139',
                'internal_sn' => '3918',
                'item_code' => '1-8486-3',
                'variant' => 'AW139',
                'mmel' => 'AW139-MMEL',
                'title' => 'AW139 Safety Equipment Dispatch Reference',
            ],
            [
                'id' => '3',
                'code' => 'MEL-AW139-003',
                'equipment_code' => '18',
                'fl_code' => '9M-WAV',
                'serial_number' => '41376',
                'registration' => '9M-WAV',
                'type' => 'AW139',
                'internal_sn' => '1862',
                'item_code' => '2-8486-3',
                'variant' => 'AW139',
                'mmel' => 'AW139-MMEL',
                'title' => 'AW139 Approved Operational Minimum Equipment List',
            ],
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    public static function searchLookup(string $term = ''): Collection
    {
        $needle = mb_strtolower(trim($term));

        if ($needle === '') {
            return self::lookupRows()->values();
        }

        return self::lookupRows()
            ->filter(static function (array $row) use ($needle): bool {
                return mb_stripos(implode(' ', $row), $needle) !== false;
            })
            ->values();
    }

    /**
     * @return array<string, string>|null
     */
    public static function findLookup(int|string|null $id): ?array
    {
        if ($id === null || $id === '') {
            return null;
        }

        return self::lookupRows()->firstWhere('id', (string) $id);
    }

    /**
     * @return array<string, string>
     */
    public static function statusOptions(): array
    {
        return [
            '0000014' => '0000014  -  Draft',
            '0000002' => '0000002  -  Released',
            '0000012' => '0000012  -  Approved',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function preview(string $scope, string $status): array
    {
        $statusMeta = match ($status) {
            '0000002' => [
                'revision_number' => '0000002',
                'revision_date' => '14.02.26',
                'create_date' => '10.02.26',
                'created_by' => 'OPS MEL',
                'update_date' => '16.02.26',
                'updated_by' => 'OPS MEL',
            ],
            '0000012' => [
                'revision_number' => '0000012',
                'revision_date' => '28.03.26',
                'create_date' => '22.03.26',
                'created_by' => 'Engineering',
                'update_date' => '30.03.26',
                'updated_by' => 'Engineering',
            ],
            default => [
                'revision_number' => '0000014',
                'revision_date' => '31.03.26',
                'create_date' => '31.03.26',
                'created_by' => 'Engineering',
                'update_date' => '31.03.26',
                'updated_by' => 'Engineering',
            ],
        };

        $base = [
            'mmel' => 'AW139-MMEL',
            'title' => 'AW139 Operational Minimum Equipment List',
        ];

        if ($scope === 'equipment') {
            return $base + $statusMeta + [
                'equipment_no' => '1',
                'internal_sn' => '31324',
                'item_code' => 'AW139',
                'variant' => 'AW139',
                'code' => '',
                'serial_number' => '',
                'registration' => '',
                'type' => '',
            ];
        }

        return $base + $statusMeta + [
            'code' => '9M-WAA',
            'serial_number' => '31324',
            'registration' => 'M104-04',
            'type' => 'AW139',
            'equipment_no' => '',
            'internal_sn' => '',
            'item_code' => '',
            'variant' => '',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    public static function items(string $scope): Collection
    {
        $functionalLocationItems = [
            ['reference' => 'MEL 21-51-01', 'title' => 'Cabin air distribution system operational dispatch allowance', 'category' => 'Air Conditioning'],
            ['reference' => 'MEL 22-11-01', 'title' => 'Autopilot minimum dispatch configuration', 'category' => 'Auto Flight'],
            ['reference' => 'MEL 23-15-03', 'title' => 'Passenger communication system with deferred handset', 'category' => 'Communications'],
            ['reference' => 'MEL 34-21-02', 'title' => 'Weather radar alternate operating limitation', 'category' => 'Navigation'],
            ['reference' => 'MEL 52-10-01', 'title' => 'Passenger door warning and visual check requirement', 'category' => 'Doors'],
        ];

        $equipmentItems = [
            ['reference' => 'MEL EQ-01', 'title' => 'Life raft serialized unit dispatch deferral tracking', 'category' => 'Safety Equipment'],
            ['reference' => 'MEL EQ-02', 'title' => 'HALO lifejacket operational stock substitution', 'category' => 'Safety Equipment'],
            ['reference' => 'MEL EQ-03', 'title' => 'Tow bar head availability with tooling fallback', 'category' => 'Ground Support'],
            ['reference' => 'MEL EQ-04', 'title' => 'Pitot static tester pooled inventory dispatch rule', 'category' => 'Tools'],
        ];

        return collect($scope === 'equipment' ? $equipmentItems : $functionalLocationItems);
    }
}
