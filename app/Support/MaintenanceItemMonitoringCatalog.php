<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;

class MaintenanceItemMonitoringCatalog
{
    /**
     * @return \Illuminate\Support\Collection<int, array<string, string|bool>>
     */
    public static function all(): Collection
    {
        return collect([
            ['item_no' => '00026032', 'description' => 'AEROLITE 10 LIFERAFT', 'item_group' => 'SAFETY & SURVIVAL EQP', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '00029020', 'description' => 'LIFERAFT ASSY', 'item_group' => 'SAFETY & SURVIVAL EQP', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '00029044', 'description' => 'LIFE RAFT AERO', 'item_group' => 'SAFETY & SURVIVAL EQP', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '00029056', 'description' => 'LIFE RAFT 14RM', 'item_group' => 'SAFETY & SURVIVAL EQP', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '00029061', 'description' => 'LIFE RAFT F14R', 'item_group' => 'SAFETY & SURVIVAL EQP', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '00029065', 'description' => 'SAR F10 HELIRAFT', 'item_group' => 'SAFETY & SURVIVAL EQP', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '00031010', 'description' => 'HALO LIFEJACKET', 'item_group' => 'SAFETY & SURVIVAL EQP', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => true, 'task_lists' => false],
            ['item_no' => '00-23-1099', 'description' => 'DEPLOYMENT BAG', 'item_group' => 'CONSUMABLE', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '004-RLI-00U', 'description' => 'Base Station, Rad', 'item_group' => 'TOOLS AND GSE', 'category_part' => '', 'is_tool' => true, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '004RLI-21U-1', 'description' => 'POLYCON BASE', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '01-0605-0000', 'description' => 'TOW BAR HEAD', 'item_group' => 'TOOLS AND GSE', 'category_part' => '', 'is_tool' => true, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '01-0770028-0', 'description' => 'POWER SUPPLY', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '01-0770879-0', 'description' => 'POWER SUPPLY', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '01-0770905-0', 'description' => 'ANTI COLLISION LIGHT', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '01-0771110-0', 'description' => 'GREEN LED POSITION LIGHT', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '011-00562-00', 'description' => 'GP500 WITH OI', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '011-01-008', 'description' => 'PITOT STATIC TESTER', 'item_group' => 'TOOLS AND GSE', 'category_part' => '', 'is_tool' => true, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '01-1127-0000', 'description' => 'TOWBAR S-76', 'item_group' => 'TOOLS AND GSE', 'category_part' => '', 'is_tool' => true, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '01-1202-0000', 'description' => 'TOW BAR MULTI TOOL', 'item_group' => 'TOOLS AND GSE', 'category_part' => '', 'is_tool' => true, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '0129G', 'description' => 'OUTSIDE AIR TEMP SENSOR', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '017125-000', 'description' => 'SENSOR', 'item_group' => 'CONSUMABLE', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '0189-2006-02', 'description' => 'INVERTER', 'item_group' => 'AIRCRAFT SPARES', 'category_part' => '', 'is_tool' => false, 'serialized' => true, 'counters' => false, 'task_lists' => false],
            ['item_no' => '02-2TD20', 'description' => 'TOWING TRUCK', 'item_group' => 'TOOLS AND GSE', 'category_part' => '', 'is_tool' => true, 'serialized' => true, 'counters' => false, 'task_lists' => false],
        ]);
    }
}
