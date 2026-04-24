<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class UserGroupsPage extends Component
{
    public string $filterType = UserGroup::TYPE_AUTHORIZATION;

    public ?int $selectedGroupId = null;

    // Group detail form
    public string $name = '';

    public string $description = '';

    public string $group_type = UserGroup::TYPE_AUTHORIZATION;

    public ?string $active_from = null;

    public ?string $active_to = null;

    // Member picker
    public string $memberSearch = '';

    public function mount(): void
    {
        $first = UserGroup::where('group_type', $this->filterType)->orderBy('name')->first();
        if ($first !== null) {
            $this->selectGroup($first->id);
        }
    }

    public function updatingFilterType(): void
    {
        $this->selectedGroupId = null;
        $this->resetForm();
    }

    public function updatedFilterType(): void
    {
        $first = UserGroup::where('group_type', $this->filterType)->orderBy('name')->first();
        if ($first !== null) {
            $this->selectGroup($first->id);
        }
    }

    public function selectGroup(int $id): void
    {
        $group = UserGroup::find($id);
        if ($group === null) {
            return;
        }

        $this->selectedGroupId = $group->id;
        $this->name = $group->name;
        $this->description = $group->description ?? '';
        $this->group_type = $group->group_type;
        $this->active_from = $group->active_from?->format('Y-m-d');
        $this->active_to = $group->active_to?->format('Y-m-d');
    }

    public function createGroup(): void
    {
        $newGroup = UserGroup::create([
            'name' => 'New Group',
            'description' => null,
            'group_type' => $this->filterType,
        ]);

        $this->selectGroup($newGroup->id);
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        if ($this->selectedGroupId === null) {
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'group_type' => 'required|string',
        ]);

        UserGroup::where('id', $this->selectedGroupId)->update([
            'name' => $this->name,
            'description' => $this->description ?: null,
            'group_type' => $this->group_type,
            'active_from' => $this->active_from ?: null,
            'active_to' => $this->active_to ?: null,
        ]);

        $this->dispatch('record-saved');
    }

    #[On('cancel-edit-form')]
    public function cancelEdit(): void
    {
        if ($this->selectedGroupId !== null) {
            $this->selectGroup($this->selectedGroupId);
        }
        $this->dispatch('record-saved');
    }

    public function addMember(int $userId): void
    {
        if ($this->selectedGroupId === null) {
            return;
        }

        DB::table('user_group_user')->updateOrInsert(
            ['user_group_id' => $this->selectedGroupId, 'user_id' => $userId],
            [
                'from_date' => now()->format('Y-m-d'),
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }

    public function removeMember(int $userId): void
    {
        if ($this->selectedGroupId === null) {
            return;
        }

        DB::table('user_group_user')
            ->where('user_group_id', $this->selectedGroupId)
            ->where('user_id', $userId)
            ->delete();
    }

    private function resetForm(): void
    {
        $this->name = '';
        $this->description = '';
        $this->group_type = $this->filterType;
        $this->active_from = null;
        $this->active_to = null;
    }

    public function render()
    {
        $groups = UserGroup::where('group_type', $this->filterType)
            ->orderBy('name')
            ->get();

        $members = [];
        $candidateUsers = [];
        if ($this->selectedGroupId !== null) {
            $group = UserGroup::with('users')->find($this->selectedGroupId);
            if ($group !== null) {
                $members = $group->users->map(fn (User $u): array => [
                    'id' => $u->id,
                    'user_code' => $u->user_code,
                    'name' => $u->name,
                    'department' => $u->department,
                    'from' => $u->pivot->from_date,
                    'to' => $u->pivot->to_date,
                ])->all();

                $memberIds = $group->users->pluck('id')->all();
                $query = User::query()->whereNotIn('id', $memberIds)->orderBy('user_code');
                if ($this->memberSearch !== '') {
                    $needle = '%' . $this->memberSearch . '%';
                    $query->where(function ($q) use ($needle) {
                        $q->where('user_code', 'like', $needle)
                            ->orWhere('name', 'like', $needle);
                    });
                }
                $candidateUsers = $query->limit(20)->get(['id', 'user_code', 'name'])->all();
            }
        }

        return view('livewire.admin.user-groups-page', [
            'groups' => $groups,
            'members' => $members,
            'candidateUsers' => $candidateUsers,
            'groupTypes' => UserGroup::GROUP_TYPES,
        ]);
    }
}
