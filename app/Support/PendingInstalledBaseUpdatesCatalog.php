<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class PendingInstalledBaseUpdatesCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, string|bool>>
     */
    public static function all(): Collection
    {
        return collect([
            ['code' => '06477', 'type' => 'OOP Life Limit', 'status' => 'Closed', 'work_center' => '', 'object_type' => 'Functional Location', 'object_ref' => '9M-WSV', 'item_code' => 'AW189', 'serial_number' => '49051', 'category_part' => '9M-WSV', 'repair_event' => '37674', 'start_date' => '18.05.19', 'title' => 'Detailed inspection package', 'display_open' => true],
            ['code' => '06478', 'type' => 'OOP Life Limit', 'status' => 'Closed', 'work_center' => '', 'object_type' => 'Functional Location', 'object_ref' => '9M-WSV', 'item_code' => 'AW189', 'serial_number' => '49051', 'category_part' => '9M-WSV', 'repair_event' => '37674', 'start_date' => '18.05.19', 'title' => 'Detailed inspection package', 'display_open' => true],
            ['code' => '204352', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category_part' => '', 'repair_event' => '120043', 'start_date' => '', 'title' => 'Emergency power check', 'display_open' => true],
            ['code' => '265HOP190', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => 'Avionic', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category_part' => '', 'repair_event' => '41651', 'start_date' => '', 'title' => 'Recertification review', 'display_open' => true],
            ['code' => '300028', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Equipment', 'object_ref' => '18333', 'item_code' => '3G2560/V0334', 'serial_number' => '109', 'category_part' => 'H/T LLP', 'repair_event' => '109628', 'start_date' => '', 'title' => 'OPS req parts', 'display_open' => true],
            ['code' => '32761', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category_part' => '', 'repair_event' => '40071', 'start_date' => '', 'title' => 'Recertification batch', 'display_open' => true],
            ['code' => '83715', 'type' => 'OOP Life Limit', 'status' => 'Closed', 'work_center' => '', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAQ', 'item_code' => 'AW139', 'serial_number' => '31419', 'category_part' => '9M-WAQ', 'repair_event' => '95953', 'start_date' => '26.05.23', 'title' => 'Fuel tanks', 'display_open' => false],
            ['code' => 'ALJ03586 D3', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => 'Mechanical', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category_part' => '', 'repair_event' => '41651', 'start_date' => '', 'title' => 'Robbery PLB base change', 'display_open' => true],
            ['code' => 'CC-1188', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => 'Avionic', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category_part' => '', 'repair_event' => '37926', 'start_date' => '', 'title' => 'Display unit replacement', 'display_open' => true],
            ['code' => 'CW1261', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category_part' => '', 'repair_event' => '41651', 'start_date' => '', 'title' => 'Aircond hose install', 'display_open' => true],
            ['code' => 'CW1282', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Equipment', 'object_ref' => '41556', 'item_code' => '0003100101484', 'serial_number' => '0003100101484', 'category_part' => 'H/T LLP', 'repair_event' => '109628', 'start_date' => '', 'title' => 'Cannibalisation review', 'display_open' => true],
            ['code' => 'CW1283', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category_part' => '', 'repair_event' => '109628', 'start_date' => '', 'title' => 'Cannibalisation review', 'display_open' => true],
            ['code' => 'CW1284', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Item Code', 'object_ref' => '00031010', 'item_code' => '1.000000', 'serial_number' => '', 'category_part' => 'HALO LIFEJACKET', 'repair_event' => '109628', 'start_date' => '', 'title' => 'Cannibalisation review', 'display_open' => false],
            ['code' => 'CW1285', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => 'Safety', 'object_type' => 'Item Code', 'object_ref' => '00031010', 'item_code' => '4.000000', 'serial_number' => '', 'category_part' => 'HALO LIFEJACKET', 'repair_event' => '109628', 'start_date' => '', 'title' => 'Cannibalisation review', 'display_open' => false],
            ['code' => 'CW1286', 'type' => 'Repair Order', 'status' => 'Planned', 'work_center' => '', 'object_type' => 'Item Code', 'object_ref' => '00031010', 'item_code' => '4.000000', 'serial_number' => '', 'category_part' => 'HALO LIFEJACKET', 'repair_event' => '109628', 'start_date' => '', 'title' => 'Certification batch', 'display_open' => false],
        ]);
    }
}
