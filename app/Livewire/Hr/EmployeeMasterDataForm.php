<?php

declare(strict_types=1);

namespace App\Livewire\Hr;

use App\Models\Employee;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Employee Master Data — full form component.
 *
 * Holds every header + simple-tab field on the SAP Employee Master Data
 * card (Address / Administration / Personal / Finance / Flight Ops home
 * base / Remarks). Uses the Edit Record toggle pattern shared with the
 * Customer Equipment Card and FL show form: read-only by default,
 * editable after the user clicks Edit Record at the page level.
 *
 * Out of scope for this component: child-table tabs (Membership Roles /
 * Teams, Flight Ops Crew Positions / Assignments, Attachments). Those
 * become their own Livewire components in follow-up PRs once the row-
 * management UX is designed.
 */
class EmployeeMasterDataForm extends Component
{
    public const STATUS_OPTIONS = ['Active', 'On Leave', 'Suspended', 'Terminated'];
    public const GENDER_OPTIONS = ['Male', 'Female', 'Other'];
    public const MARITAL_STATUS_OPTIONS = ['Single', 'Married', 'Divorced', 'Widowed'];
    public const PERIOD_OPTIONS = ['Hour', 'Day', 'Week', 'Month', 'Year'];

    public int $employeeId;
    public bool $initialEditing = false;

    // Header
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $employee_no = '';
    public string $ext_employee_no = '';
    public bool $active_employee = true;
    public string $job_title = '';
    public string $position = '';
    public string $department = '';
    public string $branch = '';
    public string $manager_id = '';
    public string $user_code = '';
    public string $sales_employee = '';
    public string $cost_center = '';
    public string $office_phone = '';
    public string $office_phone_ext = '';
    public string $mobile_phone = '';
    public string $pager = '';
    public string $home_phone = '';
    public string $fax = '';
    public string $email = '';
    public string $linked_vendor = '';

    // Address — Work
    public string $work_street = '';
    public string $work_street_no = '';
    public string $work_block = '';
    public string $work_building_floor_room = '';
    public string $work_zip_code = '';
    public string $work_city = '';
    public string $work_county = '';
    public string $work_state = '';
    public string $work_country = '';
    // Address — Home
    public string $home_street = '';
    public string $home_street_no = '';
    public string $home_block = '';
    public string $home_building_floor_room = '';
    public string $home_zip_code = '';
    public string $home_city = '';
    public string $home_county = '';
    public string $home_state = '';
    public string $home_country = '';

    // Administration
    public string $start_date = '';
    public string $status = '';
    public string $termination_date = '';
    public string $termination_reason = '';
    public string $reference_1 = '';
    public string $reference_1_from = '';
    public string $reference_1_to = '';
    public string $reference_2 = '';
    public string $reference_2_from = '';
    public string $reference_2_to = '';
    public string $admin_remarks = '';
    public string $work_profile = '';

    // Personal
    public string $gender = '';
    public string $date_of_birth = '';
    public string $country_of_birth = '';
    public string $marital_status = '';
    public string $number_of_children = '';
    public string $id_no = '';
    public string $citizenship = '';
    public string $passport_no = '';
    public string $passport_expiration_date = '';
    public string $passport_issue_date = '';
    public string $passport_issuer = '';

    // Finance
    public string $salary_amount = '';
    public string $salary_period = '';
    public string $employee_costs_amount = '';
    public string $employee_costs_period = '';
    public string $bank = '';
    public string $bank_account_no = '';
    public string $bank_branch = '';

    // Flight Ops
    public string $home_base = '';

    // Remarks
    public string $remarks = '';

    public function mount(int $employeeId, bool $initialEditing = false): void
    {
        $this->employeeId = $employeeId;
        $this->initialEditing = $initialEditing;
        $this->loadFromDb();
    }

    private function loadFromDb(): void
    {
        $emp = Employee::find($this->employeeId);

        if ($emp === null) {
            return;
        }

        foreach ($this->fillableFields() as $field) {
            $value = $emp->{$field} ?? '';

            // Dates / decimals coerced to string for the form.
            if ($value instanceof \DateTimeInterface) {
                $value = $value->format('Y-m-d');
            }

            $this->{$field} = (string) $value;
        }

        $this->active_employee = (bool) $emp->active_employee;
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $emp = Employee::find($this->employeeId);

        if ($emp === null) {
            return;
        }

        $payload = [];
        foreach ($this->fillableFields() as $field) {
            $value = $this->{$field};
            $payload[$field] = $value === '' ? null : $value;
        }
        $payload['active_employee'] = $this->active_employee;

        $emp->update($payload);

        $this->dispatch('record-saved');
    }

    #[On('cancel-edit-form')]
    public function cancelEdit(): void
    {
        $this->loadFromDb();
        $this->dispatch('record-saved');
    }

    /**
     * The list of properties that map 1:1 to Employee columns. The boolean
     * active_employee is handled separately because Livewire's string-typed
     * form props don't fit the cast.
     *
     * @return array<int, string>
     */
    private function fillableFields(): array
    {
        return [
            'first_name', 'middle_name', 'last_name',
            'employee_no', 'ext_employee_no',
            'job_title', 'position', 'department', 'branch',
            'manager_id', 'user_code', 'sales_employee', 'cost_center',
            'office_phone', 'office_phone_ext', 'mobile_phone', 'pager',
            'home_phone', 'fax', 'email', 'linked_vendor',
            'work_street', 'work_street_no', 'work_block', 'work_building_floor_room',
            'work_zip_code', 'work_city', 'work_county', 'work_state', 'work_country',
            'home_street', 'home_street_no', 'home_block', 'home_building_floor_room',
            'home_zip_code', 'home_city', 'home_county', 'home_state', 'home_country',
            'start_date', 'status', 'termination_date', 'termination_reason',
            'reference_1', 'reference_1_from', 'reference_1_to',
            'reference_2', 'reference_2_from', 'reference_2_to',
            'admin_remarks', 'work_profile',
            'gender', 'date_of_birth', 'country_of_birth', 'marital_status',
            'number_of_children', 'id_no', 'citizenship',
            'passport_no', 'passport_expiration_date', 'passport_issue_date', 'passport_issuer',
            'salary_amount', 'salary_period',
            'employee_costs_amount', 'employee_costs_period',
            'bank', 'bank_account_no', 'bank_branch',
            'home_base',
            'remarks',
        ];
    }

    public function render()
    {
        return view('livewire.hr.employee-master-data-form');
    }
}
