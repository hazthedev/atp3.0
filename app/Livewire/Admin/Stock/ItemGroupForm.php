<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Stock;

use App\Models\GlAccount;
use App\Models\GlAccountAssignment;
use App\Models\ItemGroup;
use App\Models\Warehouse;
use Livewire\Attributes\On;
use Livewire\Component;

class ItemGroupForm extends Component
{
    public ?int $itemGroupId = null;

    public string $mode = 'edit';

    public string $tab = 'general';

    // Header
    public string $name = '';

    // General tab
    public string $default_uom_group = '';

    public ?int $lead_time_days = null;

    public string $default_valuation_method = ItemGroup::VALUATION_FIFO;

    /**
     * Default bin locations grid, one row per warehouse.
     * Shape: [warehouse_id => ['warehouse_code' => ..., 'warehouse_name' => ..., 'default_bin_location' => ..., 'enforce' => bool]]
     *
     * @var array<int, array<string, mixed>>
     */
    public array $binDefaults = [];

    /**
     * Accounting tab — one row per GlAccountAssignment::ACCOUNT_TYPES key.
     *
     * @var array<string, ?int>
     */
    public array $accountAssignments = [];

    public function mount(?int $itemGroupId = null, string $mode = 'edit'): void
    {
        $this->mode = $mode;
        $this->itemGroupId = $itemGroupId;

        $this->initBinDefaults();
        $this->initAccountAssignments();

        if ($mode === 'edit' && $itemGroupId !== null) {
            $this->loadFromDb();
        }
    }

    private function initBinDefaults(): void
    {
        $this->binDefaults = [];
        foreach (Warehouse::orderBy('code')->get() as $warehouse) {
            $this->binDefaults[(int) $warehouse->id] = [
                'warehouse_code' => $warehouse->code,
                'warehouse_name' => $warehouse->name,
                'default_bin_location' => '',
                'enforce' => false,
            ];
        }
    }

    private function initAccountAssignments(): void
    {
        $this->accountAssignments = [];
        foreach (array_keys(GlAccountAssignment::ACCOUNT_TYPES) as $key) {
            $this->accountAssignments[$key] = null;
        }
    }

    private function loadFromDb(): void
    {
        $group = ItemGroup::with(['warehouseDefaults', 'glAccountAssignments'])->find($this->itemGroupId);
        if ($group === null) {
            return;
        }

        $this->name = $group->name;
        $this->default_uom_group = $group->default_uom_group ?? '';
        $this->lead_time_days = $group->lead_time_days;
        $this->default_valuation_method = $group->default_valuation_method ?? ItemGroup::VALUATION_FIFO;

        foreach ($group->warehouseDefaults as $warehouse) {
            $wid = (int) $warehouse->id;
            if (! isset($this->binDefaults[$wid])) {
                continue;
            }
            $this->binDefaults[$wid]['default_bin_location'] = (string) ($warehouse->pivot->default_bin_location ?? '');
            $this->binDefaults[$wid]['enforce'] = (bool) $warehouse->pivot->enforce_default_bin_location;
        }

        foreach ($group->glAccountAssignments as $assignment) {
            $this->accountAssignments[$assignment->account_type_key] = $assignment->gl_account_id !== null
                ? (int) $assignment->gl_account_id
                : null;
        }
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:item_groups,name,'.($this->itemGroupId ?? 'NULL'),
            'default_uom_group' => 'nullable|string|max:255',
            'lead_time_days' => 'nullable|integer|min:0',
            'default_valuation_method' => 'required|in:'.implode(',', ItemGroup::VALUATION_METHODS),
        ]);

        $payload = [
            'name' => $this->name,
            'default_uom_group' => $this->default_uom_group ?: null,
            'lead_time_days' => $this->lead_time_days,
            'default_valuation_method' => $this->default_valuation_method,
        ];

        if ($this->mode === 'create') {
            $group = ItemGroup::create($payload);
            $this->itemGroupId = $group->id;
            $this->mode = 'edit';
        } else {
            $group = ItemGroup::find($this->itemGroupId);
            if ($group === null) {
                return;
            }
            $group->update($payload);
        }

        $syncPayload = [];
        foreach ($this->binDefaults as $warehouseId => $row) {
            $loc = trim((string) ($row['default_bin_location'] ?? ''));
            $enforce = (bool) ($row['enforce'] ?? false);
            if ($loc === '' && ! $enforce) {
                continue;
            }
            $syncPayload[(int) $warehouseId] = [
                'default_bin_location' => $loc ?: null,
                'enforce_default_bin_location' => $enforce,
            ];
        }
        $group->warehouseDefaults()->sync($syncPayload);

        foreach ($this->accountAssignments as $key => $accountId) {
            if (! array_key_exists($key, GlAccountAssignment::ACCOUNT_TYPES)) {
                continue;
            }
            $group->glAccountAssignments()->updateOrCreate(
                ['account_type_key' => $key],
                ['gl_account_id' => $accountId ?: null]
            );
        }

        $this->dispatch('record-saved');
    }

    #[On('cancel-edit-form')]
    public function cancelEdit(): void
    {
        if ($this->mode === 'edit') {
            $this->loadFromDb();
        }
        $this->dispatch('record-saved');
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function render()
    {
        $accounts = GlAccount::orderBy('code')->get(['id', 'code', 'name']);

        return view('livewire.admin.stock.item-group-form', [
            'valuationMethods' => array_combine(ItemGroup::VALUATION_METHODS, ItemGroup::VALUATION_METHODS),
            'accountTypes' => GlAccountAssignment::ACCOUNT_TYPES,
            'accounts' => $accounts,
        ]);
    }
}
