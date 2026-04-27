<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Hr;

use App\Livewire\Hr\EmployeeMembershipForm;
use App\Models\Employee;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeMembershipFormTest extends TestCase
{
    public function test_add_role_creates_row_and_clears_input(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeMembershipForm::class, ['employeeId' => $emp->id])
            ->set('newRole', 'Senior Engineer')
            ->call('addRole')
            ->assertSet('newRole', '');

        $this->assertSame(1, $emp->roles()->count());
        $this->assertSame('Senior Engineer', $emp->roles()->first()->role);
    }

    public function test_add_role_ignores_blank_input(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeMembershipForm::class, ['employeeId' => $emp->id])
            ->set('newRole', '   ')
            ->call('addRole');

        $this->assertSame(0, $emp->roles()->count());
    }

    public function test_delete_role_removes_only_that_row(): void
    {
        $emp = Employee::factory()->create();
        $a = $emp->roles()->create(['role' => 'A', 'sort_order' => 1]);
        $b = $emp->roles()->create(['role' => 'B', 'sort_order' => 2]);

        Livewire::test(EmployeeMembershipForm::class, ['employeeId' => $emp->id])
            ->call('deleteRole', $a->id);

        $this->assertSame(1, $emp->roles()->count());
        $this->assertSame('B', $emp->roles()->first()->role);
    }

    public function test_set_role_as_default_unsets_others(): void
    {
        $emp = Employee::factory()->create();
        $a = $emp->roles()->create(['role' => 'A', 'is_default' => true, 'sort_order' => 1]);
        $b = $emp->roles()->create(['role' => 'B', 'is_default' => false, 'sort_order' => 2]);

        Livewire::test(EmployeeMembershipForm::class, ['employeeId' => $emp->id])
            ->call('setRoleAsDefault', $b->id);

        $a->refresh();
        $b->refresh();
        $this->assertFalse($a->is_default);
        $this->assertTrue($b->is_default);
    }

    public function test_add_team_creates_row_with_team_role(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeMembershipForm::class, ['employeeId' => $emp->id])
            ->set('newTeam', 'Engineering')
            ->set('newTeamRole', 'Tech Lead')
            ->call('addTeam')
            ->assertSet('newTeam', '')
            ->assertSet('newTeamRole', '');

        $this->assertSame(1, $emp->teams()->count());
        $row = $emp->teams()->first();
        $this->assertSame('Engineering', $row->team);
        $this->assertSame('Tech Lead', $row->team_role);
    }

    public function test_add_team_with_blank_team_role_persists_null(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeMembershipForm::class, ['employeeId' => $emp->id])
            ->set('newTeam', 'Solo')
            ->set('newTeamRole', '')
            ->call('addTeam');

        $this->assertNull($emp->teams()->first()->team_role);
    }

    public function test_delete_team_only_removes_targeted_row(): void
    {
        $emp = Employee::factory()->create();
        $a = $emp->teams()->create(['team' => 'A', 'sort_order' => 1]);
        $b = $emp->teams()->create(['team' => 'B', 'sort_order' => 2]);

        Livewire::test(EmployeeMembershipForm::class, ['employeeId' => $emp->id])
            ->call('deleteTeam', $a->id);

        $this->assertSame(1, $emp->teams()->count());
        $this->assertSame('B', $emp->teams()->first()->team);
    }
}
