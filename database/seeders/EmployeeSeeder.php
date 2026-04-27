<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'first_name' => 'Wan',
                'middle_name' => 'Mohammad',
                'last_name' => 'Razali',
                'employee_no' => 'WS-001',
                'ext_employee_no' => 'EXT-1001',
                'active_employee' => true,
                'job_title' => 'Senior Engineer',
                'position' => 'Lead Engineer',
                'department' => 'Engineering',
                'branch' => 'Subang HQ',
                'cost_center' => 'CC-ENG',
                'email' => 'wan.razali@example.com',
                'mobile_phone' => '+60-12-345-6789',
                'work_country' => 'Malaysia',
                'work_city' => 'Subang Jaya',
                'home_country' => 'Malaysia',
                'home_city' => 'Subang Jaya',
                'start_date' => '2019-04-29',
                'status' => 'Active',
                'gender' => 'Male',
                'marital_status' => 'Married',
                'citizenship' => 'Malaysia',
                'home_base' => 'WMSA',
                'remarks' => 'Sample employee — auto-seeded.',
            ],
            [
                'first_name' => 'Nurul',
                'last_name' => 'Aisyah',
                'employee_no' => 'WS-002',
                'ext_employee_no' => 'EXT-1002',
                'active_employee' => true,
                'job_title' => 'HR Manager',
                'position' => 'HR Manager',
                'department' => 'Human Resources',
                'branch' => 'Subang HQ',
                'cost_center' => 'CC-HR',
                'email' => 'nurul.aisyah@example.com',
                'mobile_phone' => '+60-12-555-0142',
                'work_country' => 'Malaysia',
                'work_city' => 'Subang Jaya',
                'start_date' => '2021-08-12',
                'status' => 'Active',
                'gender' => 'Female',
                'marital_status' => 'Single',
                'citizenship' => 'Malaysia',
                'home_base' => 'WMSA',
            ],
        ];

        foreach ($samples as $row) {
            Employee::updateOrCreate(
                ['employee_no' => $row['employee_no']],
                $row,
            );
        }
    }
}
