<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Hr;

use App\Livewire\Hr\EmployeeFlightOpsForm;
use App\Models\Employee;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeFlightOpsFormTest extends TestCase
{
    public function test_add_position_creates_row_and_clears_input(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeFlightOpsForm::class, ['employeeId' => $emp->id])
            ->set('newPosition', 'Captain')
            ->call('addPosition')
            ->assertSet('newPosition', '');

        $this->assertSame(1, $emp->crewPositions()->count());
        $this->assertSame('Captain', $emp->crewPositions()->first()->position);
    }

    public function test_add_position_ignores_blank_input(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeFlightOpsForm::class, ['employeeId' => $emp->id])
            ->set('newPosition', '   ')
            ->call('addPosition');

        $this->assertSame(0, $emp->crewPositions()->count());
    }

    public function test_delete_position_removes_only_targeted_row(): void
    {
        $emp = Employee::factory()->create();
        $a = $emp->crewPositions()->create(['position' => 'Captain', 'sort_order' => 1]);
        $b = $emp->crewPositions()->create(['position' => 'First Officer', 'sort_order' => 2]);

        Livewire::test(EmployeeFlightOpsForm::class, ['employeeId' => $emp->id])
            ->call('deletePosition', $a->id);

        $this->assertSame(1, $emp->crewPositions()->count());
        $this->assertSame('First Officer', $emp->crewPositions()->first()->position);
    }

    public function test_add_assignment_creates_row_and_clears_input(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeFlightOpsForm::class, ['employeeId' => $emp->id])
            ->set('newAssignment', 'AW139 fleet rotation Q3')
            ->call('addAssignment')
            ->assertSet('newAssignment', '');

        $this->assertSame(1, $emp->assignments()->count());
        $this->assertSame('AW139 fleet rotation Q3', $emp->assignments()->first()->assignment);
    }

    public function test_add_assignment_ignores_blank_input(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeFlightOpsForm::class, ['employeeId' => $emp->id])
            ->set('newAssignment', '')
            ->call('addAssignment');

        $this->assertSame(0, $emp->assignments()->count());
    }

    public function test_delete_assignment_removes_only_targeted_row(): void
    {
        $emp = Employee::factory()->create();
        $a = $emp->assignments()->create(['assignment' => 'A', 'sort_order' => 1]);
        $b = $emp->assignments()->create(['assignment' => 'B', 'sort_order' => 2]);

        Livewire::test(EmployeeFlightOpsForm::class, ['employeeId' => $emp->id])
            ->call('deleteAssignment', $a->id);

        $this->assertSame(1, $emp->assignments()->count());
        $this->assertSame('B', $emp->assignments()->first()->assignment);
    }
}
