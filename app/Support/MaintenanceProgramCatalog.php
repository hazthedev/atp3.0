<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class MaintenanceProgramCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public static function all(): Collection
    {
        return collect([
            [
                'id' => '1',
                'code' => '000001',
                'name' => 'AW139 Base Maintenance Program',
                'status' => 'Draft',
                'external_ref' => 'AW139-MP-01',
                'version' => '1.0',
                'effective_date' => '01.04.26',
                'create_date' => '26.05.25',
                'created_by' => 'Engineering',
                'update_date' => '30.03.26',
                'updated_by' => 'Engineering',
                'apply_to' => ['Equipment', 'Functional Location'],
                'visits' => [
                    ['visit' => 'A-Check', 'interval' => '600 FH', 'status' => 'Draft'],
                    ['visit' => 'B-Check', 'interval' => '1200 FH', 'status' => 'Draft'],
                ],
                'task_lists' => [
                    ['active' => 'Yes', 'task_list_ref' => 'AW139 SB 139-429', 'keyword' => 'Weight Extension', 'chapter' => 'AC', 'section' => '00'],
                    ['active' => 'Yes', 'task_list_ref' => 'AW139 MP 21-51-01', 'keyword' => 'Air Conditioning', 'chapter' => '21', 'section' => '51'],
                ],
                'applied_to_rows' => [
                    ['type' => 'Functional Location', 'reference' => '9M-WAA'],
                    ['type' => 'Functional Location', 'reference' => '9M-WAB'],
                ],
            ],
            [
                'id' => '2',
                'code' => '000002',
                'name' => 'AW139 Offshore Reliability Program',
                'status' => 'Released',
                'external_ref' => 'AW139-MP-02',
                'version' => '2.1',
                'effective_date' => '15.03.26',
                'create_date' => '10.02.26',
                'created_by' => 'Planning',
                'update_date' => '18.03.26',
                'updated_by' => 'Planning',
                'apply_to' => ['Functional Location'],
                'visits' => [
                    ['visit' => 'Phase 1', 'interval' => '400 FH', 'status' => 'Released'],
                ],
                'task_lists' => [
                    ['active' => 'Yes', 'task_list_ref' => 'AW139 REL 32-00', 'keyword' => 'Landing Gear', 'chapter' => '32', 'section' => '00'],
                ],
                'applied_to_rows' => [
                    ['type' => 'Functional Location', 'reference' => '9M-WAG'],
                ],
            ],
            [
                'id' => '3',
                'code' => '000003',
                'name' => 'AW189 Transition Program',
                'status' => 'Approved',
                'external_ref' => 'AW189-MP-03',
                'version' => '1.4',
                'effective_date' => '21.03.26',
                'create_date' => '03.01.26',
                'created_by' => 'Engineering',
                'update_date' => '29.03.26',
                'updated_by' => 'Engineering',
                'apply_to' => ['Equipment'],
                'visits' => [],
                'task_lists' => [],
                'applied_to_rows' => [],
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
                    $row['name'],
                    $row['status'],
                    $row['external_ref'],
                    $row['version'],
                ]);

                return mb_stripos($haystack, $needle) !== false;
            })
            ->values();
    }
}
