<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class FunctionalLocationCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public static function all(): Collection
    {
        $baseRecords = collect([
            ['id' => 1, 'code' => '9M-WAA', 'serial_no' => '31324', 'registration' => 'M104-04', 'type' => 'AW139'],
            ['id' => 2, 'code' => '9M-WAB', 'serial_no' => '31326', 'registration' => 'M104-08', 'type' => 'AW139'],
            ['id' => 3, 'code' => '9M-WAD', 'serial_no' => '31336', 'registration' => 'M104-01', 'type' => 'AW139'],
            ['id' => 4, 'code' => '9M-WAE', 'serial_no' => '31340', 'registration' => 'M104-04', 'type' => 'AW139'],
            ['id' => 5, 'code' => '9M-WAF', 'serial_no' => '31342', 'registration' => 'M104-02', 'type' => 'AW139'],
            ['id' => 6, 'code' => '9M-WAG', 'serial_no' => '31343', 'registration' => 'M104-03', 'type' => 'AW139'],
            ['id' => 7, 'code' => '9M-WAH', 'serial_no' => '31344', 'registration' => 'M104-07', 'type' => 'AW139'],
            ['id' => 8, 'code' => '9M-WAI', 'serial_no' => '31349', 'registration' => 'M104-05', 'type' => 'AW139'],
            ['id' => 9, 'code' => '9M-WAL', 'serial_no' => '31384', 'registration' => 'M104-06', 'type' => 'AW139'],
            ['id' => 10, 'code' => '9M-WAV', 'serial_no' => '41376', 'registration' => '9M-WAV', 'type' => 'AW139'],
        ]);

        $defaults = [
            'status' => 'Airworthy',
            'maintenance_plan' => 'AW139 AMP ISS 7 REV 4 / GOCOM',
            'operator_code' => '300028',
            'operator_name' => '*WESTSTAR',
            'owner_code' => '300028',
            'owner_name' => '*WESTSTAR',
            'mel' => 'Not assigned',
            'aircraft_class' => 'Medium Twin',
            'mission_type' => 'Offshore Transport',
            'maint_center_code' => 'WMSZ-01',
            'maint_center_name' => 'Weststar Subang',
            'environment_type' => 'Marine / Coastal',
            'oi_type' => 'Passenger Transport',
            'ac_max_to_weight' => '6,800 kg',
            'ac_empty_weight' => '4,358 kg',
            'address_name' => 'Weststar Aviation Services',
            'street' => 'Jalan Lapangan Terbang',
            'block' => 'Hangar 2',
            'city' => 'Subang',
            'zip_code' => '47200',
            'county' => 'Petaling',
            'state' => 'selangor',
            'country' => 'Malaysia',
            'date_of_purchase' => '18 Sep 2013',
            'purchase_price' => '34,850,000',
            'cum_flight_time' => '5461:58',
        ];

        return $baseRecords->map(function (array $record) use ($defaults): array {
            return array_merge($defaults, $record, [
                'utilization_model' => $record['code'],
                'equipment_reference' => 'EQ-' . str_pad((string) (7700 + $record['id']), 4, '0', STR_PAD_LEFT),
                'work_package_comment' => '202511' . str_pad((string) $record['id'], 2, '0', STR_PAD_LEFT) . '-' . $record['code'] . '-' . $record['type'],
            ]);
        });
    }

    public static function find(int|string|null $id): ?array
    {
        if ($id === null || $id === '') {
            return null;
        }

        return self::all()->firstWhere('id', (int) $id);
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
            ->filter(function (array $record) use ($needle): bool {
                $haystack = implode(' ', [
                    $record['code'],
                    $record['serial_no'],
                    $record['registration'],
                    $record['type'],
                    $record['operator_code'],
                    $record['operator_name'],
                    $record['owner_code'],
                    $record['owner_name'],
                ]);

                return mb_stripos($haystack, $needle) !== false;
            })
            ->values();
    }
}
