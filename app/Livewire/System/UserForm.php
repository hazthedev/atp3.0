<?php

declare(strict_types=1);

namespace App\Livewire\System;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

class UserForm extends Component
{
    public const BRANCH_OPTIONS = ['Main', 'KUL', 'SUBANG'];

    public const DEPARTMENT_OPTIONS = [
        'General',
        'IT',
        'Engineering',
        'Planning',
        'Tech Service',
        'Fleet Comm',
        'Finance',
        'Logistic',
        'Technical Record',
        'Eng. Supervisor',
    ];

    public ?int $userId = null;

    public string $mode = 'edit';

    public string $tab = 'general';

    // Header
    public string $user_code = '';

    public string $name = '';

    public string $defaults = '';

    public bool $is_superuser = false;

    public bool $is_mobile_user = false;

    public bool $is_group = false;

    // General
    public string $ms_windows_account = '';

    public string $email = '';

    public string $employee = '';

    public string $mobile_phone = '';

    public string $mobile_device_id = '';

    public string $fax = '';

    public string $branch = 'Main';

    public string $department = 'General';

    public string $password_input = '';

    public bool $password_never_expires = false;

    public bool $change_password_next_logon = true;

    public bool $is_locked = false;

    public bool $enable_integration_packages = false;

    public ?int $selectedGroupId = null;

    // Services
    public array $services = [];

    // Display
    public array $display = [];

    /** @var array<int, array{id: int, name: string}> */
    public array $groupOptions = [];

    public bool $groupPickerOpen = false;

    public function mount(?int $userId = null, string $mode = 'edit'): void
    {
        $this->mode = $mode;
        $this->userId = $userId;
        $this->groupOptions = UserGroup::orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (UserGroup $g): array => ['id' => $g->id, 'name' => $g->name])
            ->all();

        if ($mode === 'edit' && $userId !== null) {
            $this->loadFromDb();
        } else {
            $this->services = $this->defaultServices();
            $this->display = $this->defaultDisplay();
        }
    }

    private function loadFromDb(): void
    {
        $user = User::with('groups:id,name')->find($this->userId);
        if ($user === null) {
            return;
        }

        $this->user_code = $user->user_code ?? '';
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->defaults = $user->defaults ?? '';
        $this->is_superuser = (bool) $user->is_superuser;
        $this->is_mobile_user = (bool) $user->is_mobile_user;
        $this->is_group = (bool) $user->is_group;

        $this->ms_windows_account = $user->ms_windows_account ?? '';
        $this->employee = $user->employee ?? '';
        $this->mobile_phone = $user->mobile_phone ?? '';
        $this->mobile_device_id = $user->mobile_device_id ?? '';
        $this->fax = $user->fax ?? '';
        $this->branch = $user->branch ?? 'Main';
        $this->department = $user->department ?? 'General';
        $this->password_never_expires = (bool) $user->password_never_expires;
        $this->change_password_next_logon = (bool) $user->change_password_next_logon;
        $this->is_locked = (bool) $user->is_locked;
        $this->enable_integration_packages = (bool) $user->enable_integration_packages;

        $this->services = array_merge($this->defaultServices(), $user->services ?? []);
        $this->display = array_merge($this->defaultDisplay(), $user->display ?? []);

        // SAP-literal UI: single "primary" group. Uses the first membership if
        // multiple exist (multi-group membership still settable via User Groups page).
        $this->selectedGroupId = $user->groups->first()?->id !== null
            ? (int) $user->groups->first()->id
            : null;
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $this->validate([
            'user_code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $payload = [
            'user_code' => $this->user_code ?: null,
            'name' => $this->name,
            'email' => $this->email,
            'defaults' => $this->defaults ?: null,
            'is_superuser' => $this->is_superuser,
            'is_mobile_user' => $this->is_mobile_user,
            'is_group' => $this->is_group,
            'ms_windows_account' => $this->ms_windows_account ?: null,
            'employee' => $this->employee ?: null,
            'mobile_phone' => $this->mobile_phone ?: null,
            'mobile_device_id' => $this->mobile_device_id ?: null,
            'fax' => $this->fax ?: null,
            'branch' => $this->branch ?: 'Main',
            'department' => $this->department ?: 'General',
            'password_never_expires' => $this->password_never_expires,
            'change_password_next_logon' => $this->change_password_next_logon,
            'is_locked' => $this->is_locked,
            'enable_integration_packages' => $this->enable_integration_packages,
            'services' => $this->services,
            'display' => $this->display,
        ];

        if ($this->password_input !== '') {
            $payload['password'] = Hash::make($this->password_input);
        }

        if ($this->mode === 'create') {
            $payload['password'] = Hash::make($this->password_input !== '' ? $this->password_input : 'password');
            $user = User::create($payload);
            $this->userId = $user->id;
            $this->mode = 'edit';
        } else {
            $user = User::find($this->userId);
            if ($user === null) {
                return;
            }
            $user->update($payload);
        }

        // Sync the single primary group; null clears membership from this form's perspective.
        $user->groups()->sync($this->selectedGroupId !== null ? [$this->selectedGroupId] : []);

        $this->password_input = '';
        $this->dispatch('record-saved');
    }

    #[On('cancel-edit-form')]
    public function cancelEdit(): void
    {
        if ($this->mode === 'edit') {
            $this->loadFromDb();
        }
        $this->password_input = '';
        $this->dispatch('record-saved');
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function openGroupPicker(): void
    {
        $this->groupPickerOpen = true;
    }

    public function closeGroupPicker(): void
    {
        $this->groupPickerOpen = false;
    }

    public function chooseGroup(?int $groupId): void
    {
        $this->selectedGroupId = $groupId;
        $this->groupPickerOpen = false;
    }

    public function selectedGroupName(): string
    {
        if ($this->selectedGroupId === null) {
            return '';
        }
        foreach ($this->groupOptions as $opt) {
            if ((int) $opt['id'] === $this->selectedGroupId) {
                return $opt['name'];
            }
        }

        return '';
    }

    /** @return array<string, mixed> */
    private function defaultServices(): array
    {
        return [
            'perform_data_check' => false,
            'open_exchange_rates' => false,
            'display_recurring_postings' => false,
            'display_recurring_transactions' => false,
            'send_alert_activities' => false,
            'display_inbox' => true,
            'open_credit_voucher' => false,
            'open_postdated_checks' => false,
            'display_worklist' => true,
            'update_messages_min' => 0,
            'screen_locking_time_min' => 15,
            'open_postdated_credit_vouchers' => 'No',
            'kbd_numeric_enter_as_tab' => false,
            'kbd_numeric_period_as_separator' => false,
            'kbd_enable_document_ops_mouse_only' => false,
        ];
    }

    /** @return array<string, ?string> */
    private function defaultDisplay(): array
    {
        return [
            'skin_style' => null,
            'color' => null,
            'language' => null,
            'font' => null,
            'font_size' => null,
            'background' => null,
            'image_display' => null,
            'ext_image_processing' => null,
        ];
    }

    public function render()
    {
        return view('livewire.system.user-form', [
            'branchOptions' => self::BRANCH_OPTIONS,
            'departmentOptions' => self::DEPARTMENT_OPTIONS,
        ]);
    }
}
