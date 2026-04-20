<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CounterRef;
use Illuminate\Database\Seeder;

class CounterRefSeeder extends Seeder
{
    public function run(): void
    {
        $refs = [
            ['code' => '00000000', 'name' => 'CSN', 'measure_unit' => 'Cycle', 'sort_order' => 5, 'log_instance' => 11],
            ['code' => '00000001', 'name' => 'CSI', 'measure_unit' => 'Cycle', 'sort_order' => 7, 'log_instance' => 21, 'linked_counter' => '00000000', 'propagation_on_linked_counter' => 1],
            ['code' => '00000002', 'name' => 'CSM', 'measure_unit' => 'Cycle', 'sort_order' => 8, 'log_instance' => 13, 'linked_counter' => '00000000', 'propagation_on_linked_counter' => 1],
            ['code' => '00000003', 'name' => 'TSN', 'measure_unit' => 'Min', 'sort_order' => 1, 'log_instance' => 15],
            ['code' => '00000004', 'name' => 'TSI', 'measure_unit' => 'Min', 'sort_order' => 3, 'log_instance' => 26, 'linked_counter' => '00000003', 'propagation_on_linked_counter' => 1],
            ['code' => '00000005', 'name' => 'TSM', 'measure_unit' => 'Min', 'sort_order' => 4, 'log_instance' => 18, 'linked_counter' => '00000003', 'propagation_on_linked_counter' => 1],
            ['code' => '00000006', 'name' => 'CC', 'measure_unit' => 'Cycle', 'sort_order' => 9, 'log_instance' => 9],
            ['code' => '00000007', 'name' => 'CTC', 'measure_unit' => 'Cycle', 'sort_order' => 11, 'log_instance' => 9],
            ['code' => '00000008', 'name' => 'CTCL', 'measure_unit' => 'Cycle', 'sort_order' => 14, 'log_instance' => 9],
            ['code' => '00000009', 'name' => 'PTC', 'measure_unit' => 'Cycle', 'sort_order' => 15, 'log_instance' => 16],
            ['code' => '0000000A', 'name' => 'PTCL', 'measure_unit' => 'Cycle', 'sort_order' => 16, 'log_instance' => 11],
            ['code' => '0000000D', 'name' => 'Calendar Lim', 'measure_unit' => 'Calendar limit', 'log_instance' => 1],
            ['code' => '0000000E', 'name' => 'CSO', 'measure_unit' => 'Cycle', 'sort_order' => 6, 'log_instance' => 16, 'linked_counter' => '00000000'],
            ['code' => '0000000F', 'name' => 'TSO', 'measure_unit' => 'Min', 'sort_order' => 2, 'log_instance' => 30, 'linked_counter' => '00000003'],
            ['code' => '0000000H', 'name' => 'START[O]', 'measure_unit' => 'Nb of startings up', 'sort_order' => 18, 'log_instance' => 9, 'linked_counter' => '-0000008'],
            ['code' => '0000000J', 'name' => 'Hoist CT', 'measure_unit' => 'Quantity', 'sort_order' => 20, 'log_instance' => 5],
            ['code' => '0000000K', 'name' => 'APU/H', 'measure_unit' => 'Min', 'sort_order' => 21, 'log_instance' => 7],
            ['code' => '0000000L', 'name' => 'APU/C', 'measure_unit' => 'Cycle', 'sort_order' => 22, 'log_instance' => 7],
            ['code' => '0000000M', 'name' => 'Lift', 'measure_unit' => 'Quantity', 'sort_order' => 99, 'log_instance' => 7],
            ['code' => '0000000N', 'name' => 'CYC', 'measure_unit' => 'Cycle', 'sort_order' => 5, 'log_instance' => 6],
            ['code' => '0000000O', 'name' => 'E#1CC', 'measure_unit' => 'Cycle', 'sort_order' => 22, 'log_instance' => 5],
            ['code' => '0000000P', 'name' => 'E#2CC', 'measure_unit' => 'Cycle', 'sort_order' => 25, 'log_instance' => 3],
            ['code' => '0000000Q', 'name' => 'E#1CTC', 'measure_unit' => 'Cycle', 'sort_order' => 23, 'log_instance' => 3],
            ['code' => '0000000R', 'name' => 'E#1PTC', 'measure_unit' => 'Cycle', 'sort_order' => 24, 'log_instance' => 2],
            ['code' => '0000000S', 'name' => 'E#2CTC', 'measure_unit' => 'Cycle', 'sort_order' => 26, 'log_instance' => 2],
            ['code' => '0000000T', 'name' => 'E#2PTC', 'measure_unit' => 'Cycle', 'sort_order' => 27, 'log_instance' => 2],
            ['code' => '0000000U', 'name' => 'E#1CYC', 'measure_unit' => 'Cycle', 'sort_order' => 11, 'log_instance' => 3],
            ['code' => '0000000V', 'name' => 'ENGCYC', 'measure_unit' => 'Cycle', 'sort_order' => 50, 'log_instance' => 1],
            ['code' => '0000000W', 'name' => 'E#2CYC', 'measure_unit' => 'Cycle', 'sort_order' => 12, 'log_instance' => 2],
            ['code' => '0000000X', 'name' => 'E#1CTCL', 'measure_unit' => 'Cycle', 'sort_order' => 40, 'log_instance' => 2],
            ['code' => '0000000Y', 'name' => 'E#2CTCL', 'measure_unit' => 'Cycle', 'sort_order' => 41, 'log_instance' => 2],
            ['code' => '0000000Z', 'name' => 'E#1PTCL', 'measure_unit' => 'Cycle', 'sort_order' => 43, 'log_instance' => 2],
            ['code' => '00000010', 'name' => 'E#2PTCL', 'measure_unit' => 'Cycle', 'sort_order' => 44, 'log_instance' => 2],
            ['code' => '00000011', 'name' => 'E#1START', 'measure_unit' => 'Nb of startings up', 'sort_order' => 31, 'log_instance' => 4],
            ['code' => '00000012', 'name' => 'E#2START', 'measure_unit' => 'Nb of startings up', 'sort_order' => 32, 'log_instance' => 4],
            ['code' => '00000013', 'name' => 'APU/C[O]', 'measure_unit' => 'Cycle', 'sort_order' => 1, 'log_instance' => 1, 'linked_counter' => '0000000L', 'propagation_on_linked_counter' => 1],
            ['code' => '00000014', 'name' => 'APU/H[O]', 'measure_unit' => 'Min', 'sort_order' => 1, 'log_instance' => 1, 'linked_counter' => '0000000K', 'propagation_on_linked_counter' => 1],
            ['code' => '00000015', 'name' => 'APU/H[M]', 'measure_unit' => 'Min', 'sort_order' => 70, 'log_instance' => 2, 'linked_counter' => '0000000K', 'propagation_on_linked_counter' => 1],
            ['code' => '00000016', 'name' => 'APU/C[M]', 'measure_unit' => 'Cycle', 'sort_order' => 71, 'log_instance' => 2, 'linked_counter' => '0000000L', 'propagation_on_linked_counter' => 1],
            ['code' => '-0000007', 'name' => 'Landing', 'measure_unit' => 'Nb of landings', 'sort_order' => 98, 'log_instance' => 8],
            ['code' => '-0000008', 'name' => 'START', 'measure_unit' => 'Nb of startings up', 'sort_order' => 17, 'log_instance' => 7],
            ['code' => '-0000011', 'name' => 'Take Off', 'measure_unit' => 'Nb of Take Offs'],
        ];

        foreach ($refs as $ref) {
            CounterRef::updateOrCreate(['code' => $ref['code']], $ref);
        }
    }
}
