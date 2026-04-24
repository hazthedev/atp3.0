<?php

declare(strict_types=1);

namespace App\Livewire\System;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndexPage extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'all';

    public string $branchFilter = 'all';

    public int $perPage = 25;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'branchFilter' => ['except' => 'all'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingBranchFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()
            ->with('groups:id,name')
            ->orderBy('user_code');

        if ($this->search !== '') {
            $needle = '%' . $this->search . '%';
            $query->where(function ($q) use ($needle) {
                $q->where('user_code', 'like', $needle)
                    ->orWhere('name', 'like', $needle)
                    ->orWhere('email', 'like', $needle)
                    ->orWhere('department', 'like', $needle);
            });
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_locked', false);
        } elseif ($this->statusFilter === 'locked') {
            $query->where('is_locked', true);
        } elseif ($this->statusFilter === 'superuser') {
            $query->where('is_superuser', true);
        }

        if ($this->branchFilter !== 'all') {
            $query->where('branch', $this->branchFilter);
        }

        $branches = User::query()
            ->whereNotNull('branch')
            ->distinct()
            ->orderBy('branch')
            ->pluck('branch')
            ->all();

        return view('livewire.system.user-index-page', [
            'users' => $query->paginate($this->perPage),
            'branches' => $branches,
        ]);
    }
}
