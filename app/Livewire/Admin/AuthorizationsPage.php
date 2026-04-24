<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Authorization;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserGroup;
use Livewire\Component;

class AuthorizationsPage extends Component
{
    public string $subjectTab = 'groups'; // 'users' | 'groups'

    public ?int $subjectId = null;

    public ?int $selectedPermissionId = null;

    public string $find = '';

    public function mount(): void
    {
        $firstGroup = UserGroup::orderBy('name')->first();
        if ($firstGroup !== null) {
            $this->subjectId = $firstGroup->id;
        }
    }

    public function switchTab(string $tab): void
    {
        if (! in_array($tab, ['users', 'groups'], true)) {
            return;
        }

        $this->subjectTab = $tab;
        $this->selectedPermissionId = null;

        if ($tab === 'users') {
            $first = User::orderBy('user_code')->first();
            $this->subjectId = $first?->id;
        } else {
            $first = UserGroup::orderBy('name')->first();
            $this->subjectId = $first?->id;
        }
    }

    public function selectSubject(int $id): void
    {
        $this->subjectId = $id;
        $this->selectedPermissionId = null;
    }

    public function selectPermission(int $permissionId): void
    {
        $this->selectedPermissionId = $permissionId;
    }

    public function setLevel(string $level): void
    {
        if (! in_array($level, Authorization::LEVELS, true)) {
            return;
        }
        if ($this->subjectId === null || $this->selectedPermissionId === null) {
            return;
        }

        $subjectType = $this->subjectTab === 'users' ? 'user' : 'user_group';

        // Cascade to permission + descendants.
        $root = Permission::with('children')->find($this->selectedPermissionId);
        if ($root === null) {
            return;
        }

        foreach ($root->descendantsAndSelf() as $perm) {
            Authorization::updateOrCreate(
                [
                    'subject_type' => $subjectType,
                    'subject_id' => $this->subjectId,
                    'permission_id' => $perm->id,
                ],
                ['level' => $level],
            );
        }
    }

    /**
     * @return array<int, string>  permission_id => level
     */
    private function loadLevelsForSubject(): array
    {
        if ($this->subjectId === null) {
            return [];
        }

        $subjectType = $this->subjectTab === 'users' ? 'user' : 'user_group';

        return Authorization::where('subject_type', $subjectType)
            ->where('subject_id', $this->subjectId)
            ->pluck('level', 'permission_id')
            ->map(fn ($v) => (string) $v)
            ->all();
    }

    public function render()
    {
        $subjectList = [];
        if ($this->subjectTab === 'users') {
            $query = User::query()->orderBy('user_code');
            if ($this->find !== '') {
                $needle = '%' . $this->find . '%';
                $query->where(function ($q) use ($needle) {
                    $q->where('user_code', 'like', $needle)->orWhere('name', 'like', $needle);
                });
            }
            $subjectList = $query->get(['id', 'user_code', 'name'])
                ->map(fn (User $u): array => [
                    'id' => $u->id,
                    'label' => ($u->user_code ?? '—') . ' — ' . $u->name,
                ])
                ->all();
        } else {
            $query = UserGroup::query()->orderBy('name');
            if ($this->find !== '') {
                $query->where('name', 'like', '%' . $this->find . '%');
            }
            $subjectList = $query->get(['id', 'name'])
                ->map(fn (UserGroup $g): array => [
                    'id' => $g->id,
                    'label' => $g->name,
                ])
                ->all();
        }

        $roots = Permission::whereNull('parent_id')
            ->with('children.children.children')
            ->orderBy('sort_order')
            ->get();

        return view('livewire.admin.authorizations-page', [
            'subjectList' => $subjectList,
            'roots' => $roots,
            'levels' => $this->loadLevelsForSubject(),
        ]);
    }
}
