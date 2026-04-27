<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TechnicalLog;
use Illuminate\Database\Seeder;

/**
 * Source: @MRO_OTLG rows from weststar_atp3_aish.sql — first 20 rows as sample seed.
 *
 * For a full import, run `php artisan sap:import otlg` (built in a later phase)
 * which parses the 60-column @MRO_OTLG table directly from the SQL dump.
 */
class TechnicalLogSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'code' => '00000000', 'log_number' => '0000008H', 'aircraft_registration' => '9M-WAO',
                'status_code' => '00000003', 'discovery_date' => '2017-10-08',
                'closure_date' => '2017-10-08', 'deadline_date' => null, 'is_deferral' => false,
                'discovery_description' => 'M1. MULTI PURPOSE FLIGHT & RECORDER (12M/D INSP)',
                'corrective_description' => 'C/OUT. SATIS. REF KBR/WAO/15121',
                'work_order_code' => null,
            ],
            [
                'code' => '00000001', 'log_number' => '0000008Z', 'aircraft_registration' => '9M-WAV',
                'status_code' => '00000003', 'discovery_date' => '2017-10-16',
                'closure_date' => '2017-10-16', 'is_deferral' => false,
                'discovery_description' => "AF:\n25 HRS",
                'corrective_description' => 'M1 : EASA AD 2017-0028-E. C/O REF KBR/WAV/15036.',
            ],
            [
                'code' => '00000002', 'log_number' => '000000AG', 'aircraft_registration' => '9M-WAA',
                'status_code' => '00000003', 'discovery_date' => '2017-10-20',
                'closure_date' => '2017-10-20',
                'discovery_description' => "TO CARRY OUT EMERG SYS FLEET CHK\nREF WP KBR/WAA/15259",
                'corrective_description' => 'M1.EMERG FLOAT SYS FLEET CHK.REF WP KBR/WAA/15259',
            ],
            [
                'code' => '00000003', 'log_number' => '000000AM', 'aircraft_registration' => '9M-WAA',
                'status_code' => '00000003', 'discovery_date' => '2017-10-23',
                'closure_date' => '2017-10-23',
                'discovery_description' => 'M1.OPERATIONAL REQ AFT FLOAT LEFT 9M-WAA SWAPPED 9M-WAD. REF WP KBR/WAA/15266',
            ],
            [
                'code' => '00000004', 'log_number' => '000000BB', 'aircraft_registration' => '9M-WAA',
                'status_code' => '00000003', 'discovery_date' => '2017-10-25',
                'closure_date' => '2017-10-25',
                'discovery_description' => "WORK DONE:\nM1) EASA AD 2017-0160 - KBR/WAA/15031\nM2) 25HRS/7DAYS ACCP INSP\nM3) 25HRS + SB 139-468 PT1",
            ],
            [
                'code' => '00000005', 'log_number' => '000000BK', 'aircraft_registration' => '9M-WAA',
                'status_code' => '00000003', 'discovery_date' => '2017-10-26',
                'closure_date' => '2017-10-26',
                'corrective_description' => 'M1. EASA AD 2017-0160 INSP C/OUT - KBR/WAA/15031',
            ],
            // --- Fleet Dashboard-relevant deferred entries ---
            [
                'code' => '00000020', 'log_number' => 'TL-24101', 'aircraft_registration' => '9M-WAD',
                'status_code' => '-0000021', // Deferred
                'mel_category_code' => '00000001', // MEL B
                'mel_item_ref' => 'MEL-2710',
                'ata_chapter' => '27-21',
                'discovery_date' => '2026-04-18',
                'deadline_date' => '2026-04-21',
                'is_deferral' => true,
                'discovery_description' => 'Autopilot channel intermittent dropout — PFC workaround applied',
                'workaround_description' => 'Operate on single autopilot channel per MEL B',
                'serial_number' => '31441',
            ],
            [
                'code' => '00000021', 'log_number' => 'TL-24210', 'aircraft_registration' => '9M-WBB',
                'status_code' => '-0000021',
                'mel_category_code' => '00000002', // MEL C
                'mel_item_ref' => 'MEL-3412',
                'ata_chapter' => '34-12',
                'discovery_date' => '2026-04-15',
                'deadline_date' => '2026-04-25',
                'is_deferral' => true,
                'discovery_description' => 'ADF receiver not tuning — ADC-1 inop',
                'workaround_description' => 'Operate VFR / VOR navigation only, night ops restricted',
            ],
            [
                'code' => '00000022', 'log_number' => 'TL-24305', 'aircraft_registration' => '9M-WSV',
                'status_code' => '-0000021',
                'mel_category_code' => '00000005', // CFD
                'ata_chapter' => '25-60',
                'discovery_date' => '2026-04-10',
                'deadline_date' => '2026-05-10',
                'is_deferral' => true,
                'discovery_description' => 'Cabin emergency light #3 inoperative',
                'workaround_description' => 'CFD — 30-day deferral, inform pax pre-flight',
            ],
            [
                'code' => '00000023', 'log_number' => 'TL-24312', 'aircraft_registration' => '9M-WSU',
                'status_code' => '-0000021',
                'mel_category_code' => '00000000', // MEL A
                'ata_chapter' => '21-30',
                'discovery_date' => '2026-04-22',
                'deadline_date' => '2027-04-22', // A = up to 999 days
                'is_deferral' => true,
                'discovery_description' => 'Secondary HVAC blower low airflow',
                'workaround_description' => 'Primary HVAC fully functional — MEL A restriction',
            ],
        ];

        foreach ($rows as $r) {
            TechnicalLog::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
