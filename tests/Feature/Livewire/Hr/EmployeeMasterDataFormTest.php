<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Hr;

use App\Livewire\Hr\EmployeeMasterDataForm;
use App\Models\Employee;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeMasterDataFormTest extends TestCase
{
    public function test_mount_hydrates_header_fields_from_employee(): void
    {
        $emp = Employee::factory()->create([
            'first_name' => 'Wan',
            'middle_name' => 'Mohammad',
            'last_name' => 'Razali',
            'employee_no' => 'WS-001',
            'email' => 'wan@example.com',
            'active_employee' => true,
        ]);

        Livewire::test(EmployeeMasterDataForm::class, ['employeeId' => $emp->id])
            ->assertSet('first_name', 'Wan')
            ->assertSet('middle_name', 'Mohammad')
            ->assertSet('last_name', 'Razali')
            ->assertSet('employee_no', 'WS-001')
            ->assertSet('email', 'wan@example.com')
            ->assertSet('active_employee', true);
    }

    public function test_mount_with_address_fields_hydrates_both_blocks(): void
    {
        $emp = Employee::factory()->create([
            'work_street' => '1 Work Lane',
            'work_city' => 'Subang',
            'home_street' => '5 Home Road',
            'home_city' => 'Petaling',
        ]);

        Livewire::test(EmployeeMasterDataForm::class, ['employeeId' => $emp->id])
            ->assertSet('work_street', '1 Work Lane')
            ->assertSet('work_city', 'Subang')
            ->assertSet('home_street', '5 Home Road')
            ->assertSet('home_city', 'Petaling');
    }

    public function test_save_persists_changes_across_tabs(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeMasterDataForm::class, ['employeeId' => $emp->id])
            ->set('job_title', 'Senior Engineer')
            ->set('work_city', 'Subang')
            ->set('gender', 'Male')
            ->set('marital_status', 'Married')
            ->set('salary_amount', '12500.00')
            ->set('salary_period', 'Month')
            ->set('home_base', 'WMSA')
            ->set('remarks', 'Updated through Livewire.')
            ->call('save')
            ->assertDispatched('record-saved');

        $emp->refresh();
        $this->assertSame('Senior Engineer', $emp->job_title);
        $this->assertSame('Subang', $emp->work_city);
        $this->assertSame('Male', $emp->gender);
        $this->assertSame('Married', $emp->marital_status);
        $this->assertSame('12500.00', $emp->salary_amount);
        $this->assertSame('Month', $emp->salary_period);
        $this->assertSame('WMSA', $emp->home_base);
        $this->assertSame('Updated through Livewire.', $emp->remarks);
    }

    public function test_save_with_empty_string_persists_null(): void
    {
        $emp = Employee::factory()->create([
            'job_title' => 'Was set.',
            'work_city' => 'Was here.',
        ]);

        Livewire::test(EmployeeMasterDataForm::class, ['employeeId' => $emp->id])
            ->set('job_title', '')
            ->set('work_city', '')
            ->call('save');

        $emp->refresh();
        $this->assertNull($emp->job_title);
        $this->assertNull($emp->work_city);
    }

    public function test_cancel_restores_original_values(): void
    {
        $emp = Employee::factory()->create([
            'first_name' => 'Original',
            'last_name' => 'Surname',
        ]);

        Livewire::test(EmployeeMasterDataForm::class, ['employeeId' => $emp->id])
            ->set('first_name', 'Dirty')
            ->set('last_name', 'Edit')
            ->call('cancelEdit')
            ->assertSet('first_name', 'Original')
            ->assertSet('last_name', 'Surname')
            ->assertDispatched('record-saved');

        // DB unchanged
        $emp->refresh();
        $this->assertSame('Original', $emp->first_name);
        $this->assertSame('Surname', $emp->last_name);
    }

    public function test_full_name_concatenates_present_parts(): void
    {
        $emp = Employee::factory()->create([
            'first_name' => 'Wan',
            'middle_name' => 'Mohammad',
            'last_name' => 'Razali',
        ]);

        $this->assertSame('Wan Mohammad Razali', $emp->fullName());

        $emp2 = Employee::factory()->create([
            'first_name' => 'Solo',
            'middle_name' => null,
            'last_name' => 'Name',
        ]);

        $this->assertSame('Solo Name', $emp2->fullName());
    }
}
