<?php

declare(strict_types=1);

namespace App\Livewire\Hr;

use App\Models\Employee;
use App\Models\EmployeeAssignment;
use App\Models\EmployeeCrewPosition;
use Livewire\Component;

/**
 * Employee Master Data — Flight Ops tab (Crew Management Positions
 * + Employee Assignment).
 *
 * Two row editors mirroring the SAP layout:
 *   Crew Management sub-tab → Positions list (rows + add/remove)
 *   Employee Assignment sub-tab → Assignments list (rows + add/remove)
 *
 * Same row-CRUD pattern as EmployeeMembershipForm. Independent of the
 * page-level Edit Record toggle.
 */
class EmployeeFlightOpsForm extends Component
{
    public int $employeeId;

    public string $newPosition = '';
    public string $newAssignment = '';

    public function mount(int $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    public function addPosition(): void
    {
        $position = trim($this->newPosition);
        if ($position === '') {
            return;
        }

        $employee = Employee::find($this->employeeId);
        if ($employee === null) {
            return;
        }

        $employee->crewPositions()->create([
            'position' => $position,
            'sort_order' => ($employee->crewPositions()->max('sort_order') ?? 0) + 1,
        ]);

        $this->newPosition = '';
    }

    public function deletePosition(int $positionId): void
    {
        EmployeeCrewPosition::query()
            ->where('id', $positionId)
            ->where('employee_id', $this->employeeId)
            ->delete();
    }

    public function addAssignment(): void
    {
        $assignment = trim($this->newAssignment);
        if ($assignment === '') {
            return;
        }

        $employee = Employee::find($this->employeeId);
        if ($employee === null) {
            return;
        }

        $employee->assignments()->create([
            'assignment' => $assignment,
            'sort_order' => ($employee->assignments()->max('sort_order') ?? 0) + 1,
        ]);

        $this->newAssignment = '';
    }

    public function deleteAssignment(int $assignmentId): void
    {
        EmployeeAssignment::query()
            ->where('id', $assignmentId)
            ->where('employee_id', $this->employeeId)
            ->delete();
    }

    public function render()
    {
        $employee = Employee::with(['crewPositions', 'assignments'])->find($this->employeeId);

        return view('livewire.hr.employee-flight-ops-form', [
            'positions' => $employee?->crewPositions()->orderBy('sort_order')->get() ?? collect(),
            'assignments' => $employee?->assignments()->orderBy('sort_order')->get() ?? collect(),
        ]);
    }
}
