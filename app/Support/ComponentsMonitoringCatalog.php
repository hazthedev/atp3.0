<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class ComponentsMonitoringCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    public static function all(): Collection
    {
        $rows = collect([
            [
                'row_key' => 'cm-0001',
                'equipment_id' => '',
                'equipment_status' => '',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '00031010001505',
                'item_group_code' => 'SAFETY & SURVIVAL',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0002',
                'equipment_id' => '',
                'equipment_status' => '',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '3101000697',
                'item_group_code' => 'SAFETY & SURVIVAL',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0003',
                'equipment_id' => '37741',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000692',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0004',
                'equipment_id' => '37745',
                'equipment_status' => 'Removed',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000696',
                'item_group_code' => 'H/T LLP',
                'whse_code' => 'KH BOND',
                'whse_name' => 'KH BOND',
                'display_bucket' => 'warehouse_managed_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0005',
                'equipment_id' => '37747',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000699',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'applied',
            ],
            [
                'row_key' => 'cm-0006',
                'equipment_id' => '37751',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000719',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0007',
                'equipment_id' => '37757',
                'equipment_status' => 'Removed',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000739',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'non_applicable',
            ],
            [
                'row_key' => 'cm-0008',
                'equipment_id' => '37760',
                'equipment_status' => 'Removed',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000747',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0009',
                'equipment_id' => '37762',
                'equipment_status' => 'Removed',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000771',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'not_initialized_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0010',
                'equipment_id' => '37764',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000776',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0011',
                'equipment_id' => '37765',
                'equipment_status' => 'Removed',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000777',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0012',
                'equipment_id' => '37768',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000805',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0013',
                'equipment_id' => '39802',
                'equipment_status' => 'Serviceable',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000712',
                'item_group_code' => 'SAFETY & SURVIVAL',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'warehouse_managed_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0014',
                'equipment_id' => '39806',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000720',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0015',
                'equipment_id' => '39809',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000724',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0016',
                'equipment_id' => '39812',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000728',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0017',
                'equipment_id' => '39819',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000738',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0018',
                'equipment_id' => '39820',
                'equipment_status' => 'On Aircraft',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000741',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
            [
                'row_key' => 'cm-0019',
                'equipment_id' => '39831',
                'equipment_status' => 'Removed',
                'part_number' => '00031010',
                'item_name' => 'HALO LIFEJACKET',
                'serial_number' => '0003101000755',
                'item_group_code' => 'H/T LLP',
                'whse_code' => '',
                'whse_name' => '',
                'display_bucket' => 'all_serialized_parts',
                'task_state' => 'open',
            ],
        ]);

        $bucketOverrides = [
            'cm-0001' => 'critical_tasks_on_serialized_parts',
            'cm-0002' => 'critical_tasks_on_serialized_parts',
            'cm-0003' => 'not_initialized_serialized_parts',
            'cm-0004' => 'serialized_parts_with_init_task_without_work_order',
            'cm-0005' => 'serialized_parts_with_initialized_task',
            'cm-0006' => 'not_initialized_serialized_parts',
            'cm-0007' => 'serialized_parts_with_non_initialized_tasks',
            'cm-0008' => 'serialized_parts_with_non_initialized_tasks',
            'cm-0009' => 'serialized_parts_with_non_initialized_tasks',
            'cm-0010' => 'serialized_parts_with_initialized_task',
            'cm-0011' => 'serialized_parts_with_initialized_task',
            'cm-0012' => 'serialized_parts_with_initialized_task',
            'cm-0013' => 'serialized_parts_with_init_task_without_work_order',
            'cm-0014' => 'serialized_parts_with_initialized_task',
            'cm-0015' => 'serialized_parts_with_initialized_task',
            'cm-0016' => 'serialized_parts_with_initialized_task',
            'cm-0017' => 'serialized_parts_with_initialized_task',
            'cm-0018' => 'serialized_parts_with_initialized_task',
            'cm-0019' => 'serialized_parts_with_initialized_task',
        ];

        return $rows->map(static function (array $row) use ($bucketOverrides): array {
            if (isset($bucketOverrides[$row['row_key']])) {
                $row['display_bucket'] = $bucketOverrides[$row['row_key']];
            }

            return $row;
        });
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    public static function filter(string $displayOnly = 'not_initialized_serialized_parts', bool $excludeAppliedAndNonApplicableTask = false): Collection
    {
        return self::all()
            ->filter(function (array $row) use ($displayOnly, $excludeAppliedAndNonApplicableTask): bool {
                $displayMatch = match ($displayOnly) {
                    'critical_tasks_on_serialized_parts' => $row['display_bucket'] === 'critical_tasks_on_serialized_parts',
                    'serialized_parts_with_init_task_without_work_order' => $row['display_bucket'] === 'serialized_parts_with_init_task_without_work_order',
                    'serialized_parts_with_non_initialized_tasks' => $row['display_bucket'] === 'serialized_parts_with_non_initialized_tasks',
                    'serialized_parts_with_initialized_task' => $row['display_bucket'] === 'serialized_parts_with_initialized_task',
                    default => $row['display_bucket'] === 'not_initialized_serialized_parts',
                };

                $taskMatch = ! $excludeAppliedAndNonApplicableTask || $row['task_state'] === 'open';

                return $displayMatch && $taskMatch;
            })
            ->values();
    }

    /**
     * @return array<string, string>|null
     */
    public static function find(int|string|null $rowKey): ?array
    {
        if ($rowKey === null) {
            return null;
        }

        return self::all()->firstWhere('row_key', (string) $rowKey);
    }
}
