<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'middle_name' => null,
            'last_name' => $this->faker->lastName(),
            'employee_no' => 'EMP-' . $this->faker->unique()->numerify('######'),
            'ext_employee_no' => null,
            'active_employee' => true,
            'job_title' => null,
            'position' => null,
            'department' => null,
            'branch' => null,
            'manager_id' => null,
            'user_code' => null,
            'sales_employee' => null,
            'cost_center' => null,
            'office_phone' => null,
            'office_phone_ext' => null,
            'mobile_phone' => null,
            'pager' => null,
            'home_phone' => null,
            'fax' => null,
            'email' => null,
            'linked_vendor' => null,
            'photo_path' => null,
            // Address blocks left null by default — exercised by tests via state methods
            'work_street' => null,
            'home_street' => null,
            // Administration / Personal / Finance / Flight Ops / Remarks
            'start_date' => null,
            'status' => 'Active',
            'gender' => null,
            'salary_period' => null,
            'employee_costs_period' => null,
            'home_base' => null,
            'remarks' => null,
        ];
    }
}
