<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class EquipmentCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    public static function all(): Collection
    {
        $baseRecords = collect([
            ['id' => '1', 'item_no' => 'AW139', 'item_name' => 'AW139', 'serial_number' => '31324', 'old' => '', 'category_part' => '', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => 'Functional Location', 'father_reference' => 'AW139 / M104-04', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '2', 'item_no' => '4G1860F00113', 'item_name' => 'Kit MVA Assy', 'serial_number' => 'R94', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => 'Functional Location', 'father_reference' => 'AW139 / M104-04', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '3', 'item_no' => '4G1860F00113A1', 'item_name' => 'VIBRATION ABS DAT0011', 'serial_number' => '', 'old' => '', 'category_part' => 'H/T LLP', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '4', 'item_no' => '3G2140V0252', 'item_name' => 'Heating Control', 'serial_number' => '00590', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => 'Functional Location', 'father_reference' => 'AW139 / M104-04', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '5', 'item_no' => '3G2140V01451', 'item_name' => 'Shut Off Valve', 'serial_number' => '00134', 'old' => '', 'category_part' => 'H/T TCC', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '6', 'item_no' => '3G2140V01451', 'item_name' => 'Shut Off Valve', 'serial_number' => '00135', 'old' => '', 'category_part' => 'H/T TCC', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '7', 'item_no' => '3G2150V00252', 'item_name' => 'Air Cont. Control', 'serial_number' => '00864', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '8', 'item_no' => '3G2150V00252', 'item_name' => 'Air Cont. Control', 'serial_number' => '00872', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => 'Functional Location', 'father_reference' => 'AW139 / M104-04', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '9', 'item_no' => '3G2150V00353', 'item_name' => 'ECS CONTROL P', 'serial_number' => '000317', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '10', 'item_no' => '3G2150V1653', 'item_name' => 'COMPRESSOR P', 'serial_number' => '1768-0050', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '11', 'item_no' => '1768-60', 'item_name' => 'BELT', 'serial_number' => 'WA5/KB/266', 'old' => '', 'category_part' => 'H/T LLP', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '12', 'item_no' => '1768-60', 'item_name' => 'BELT', 'serial_number' => 'WA5/KB/262', 'old' => '', 'category_part' => 'H/T LLP', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '13', 'item_no' => '8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3788', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '14', 'item_no' => '8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3821', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '15', 'item_no' => '1-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3918', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => 'Functional Location', 'father_reference' => 'AW139 / M104-04', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '16', 'item_no' => '1-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '5024', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '17', 'item_no' => '2-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3559', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '18', 'item_no' => '2-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '1862', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft', 'father_object_type' => 'Functional Location', 'father_reference' => 'AW139 / M104-04', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
            ['id' => '19', 'item_no' => '7011702-948', 'item_name' => 'Guidance Control', 'serial_number' => '14052573', 'old' => '', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed', 'father_object_type' => '', 'father_reference' => '', 'operator_code' => '300028', 'operator_name' => '*WESTSTAR', 'owner_code' => '300028', 'owner_name' => '*WESTSTAR'],
        ]);

        $defaults = [
            'equipment_no' => '',
            'item_description' => '',
            'maintenance_plan' => 'AW139 AMP ISS 7 REV 4 / GOCOM',
            'mel' => '',
            'operator_name_display' => 'Weststar',
            'chapter' => 'AC',
            'section' => '00',
            'subject' => '00',
            'sheet' => '000',
            'mark' => '00',
            'mel_item' => '',
            'next_higher_serial_number' => '',
            'next_higher_item_no' => '',
            'next_higher_category_part' => '',
            'next_higher_equipment_no' => '',
            'next_higher_item_desc' => '',
            'top_assembly_serial_number' => '',
            'top_assembly_item_no' => '',
            'top_assembly_category_part' => '',
            'top_assembly_equipment_no' => '',
            'top_assembly_item_desc' => '',
            'functional_location_serial_number' => '31324',
            'functional_location_code' => '9M-WAA',
            'functional_location_registration' => 'M104-04',
            'functional_location_type' => 'AW139',
            'functional_location_position' => 'Airframe',
            'updated_by' => 'Wan Mohammad R',
            'update_date' => '29.04.19',
        ];

        return $baseRecords->map(function (array $record) use ($defaults): array {
            return array_merge($defaults, $record, [
                'equipment_no' => $record['id'],
                'item_description' => $record['item_name'],
                'operator_name_display' => trim((string) ltrim($record['operator_name'], '*')),
            ]);
        });
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

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
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
                    $row['id'],
                    $row['item_no'],
                    $row['item_name'],
                    $row['serial_number'],
                    $row['category_part'],
                    $row['variant'],
                    $row['status'],
                    $row['father_reference'],
                    $row['operator_code'],
                    $row['operator_name'],
                    $row['owner_code'],
                    $row['owner_name'],
                ]);

                return mb_stripos($haystack, $needle) !== false;
            })
            ->values();
    }
}
