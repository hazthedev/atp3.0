<?php

declare(strict_types=1);

namespace App\Livewire\Hr;

use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\EmployeeTeam;
use Livewire\Component;

/**
 * Employee Master Data — Membership tab (Roles + Teams).
 *
 * Two side-by-side row editors, each driven by its own input + Add button
 * + per-row delete. Row CRUD is independent of the page-level Edit Record
 * toggle (matches SAP behaviour: you can add/remove memberships any time
 * without entering an explicit edit mode for the whole record).
 */
class EmployeeMembershipForm extends Component
{
    public int $employeeId;

    public string $newRole = '';
    public string $newTeam = '';
    public string $newTeamRole = '';

    public function mount(int $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    public function addRole(): void
    {
        $role = trim($this->newRole);
        if ($role === '') {
            return;
        }

        $employee = Employee::find($this->employeeId);
        if ($employee === null) {
            return;
        }

        $employee->roles()->create([
            'role' => $role,
            'sort_order' => ($employee->roles()->max('sort_order') ?? 0) + 1,
        ]);

        $this->newRole = '';
    }

    public function deleteRole(int $roleId): void
    {
        EmployeeRole::query()
            ->where('id', $roleId)
            ->where('employee_id', $this->employeeId)
            ->delete();
    }

    public function setRoleAsDefault(int $roleId): void
    {
        EmployeeRole::query()
            ->where('employee_id', $this->employeeId)
            ->update(['is_default' => false]);

        EmployeeRole::query()
            ->where('id', $roleId)
            ->where('employee_id', $this->employeeId)
            ->update(['is_default' => true]);
    }

    public function addTeam(): void
    {
        $team = trim($this->newTeam);
        if ($team === '') {
            return;
        }

        $employee = Employee::find($this->employeeId);
        if ($employee === null) {
            return;
        }

        $employee->teams()->create([
            'team' => $team,
            'team_role' => trim($this->newTeamRole) ?: null,
            'sort_order' => ($employee->teams()->max('sort_order') ?? 0) + 1,
        ]);

        $this->newTeam = '';
        $this->newTeamRole = '';
    }

    public function deleteTeam(int $teamId): void
    {
        EmployeeTeam::query()
            ->where('id', $teamId)
            ->where('employee_id', $this->employeeId)
            ->delete();
    }

    public function render()
    {
        $employee = Employee::with(['roles', 'teams'])->find($this->employeeId);

        return view('livewire.hr.employee-membership-form', [
            'roles' => $employee?->roles()->orderBy('sort_order')->get() ?? collect(),
            'teams' => $employee?->teams()->orderBy('sort_order')->get() ?? collect(),
        ]);
    }
}
