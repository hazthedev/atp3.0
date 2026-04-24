<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Stock;

use App\Models\GlAccount;
use App\Models\GlAccountAssignment;
use App\Models\Warehouse;
use Livewire\Attributes\On;
use Livewire\Component;

class WarehouseForm extends Component
{
    /** @var array<int, string> */
    public const LOCATION_OPTIONS = ['Subang', 'Dili', 'Namibia', 'Kuching', 'Miri'];

    public ?int $warehouseId = null;

    public string $mode = 'edit';

    public string $tab = 'general';

    // Header
    public string $code = '';

    public string $name = '';

    // General
    public bool $inactive = false;

    public bool $drop_ship = false;

    public string $location = '';

    public bool $nettable = true;

    public bool $issue_part_for_maintenance = false;

    public bool $enable_bin_locations = false;

    // Address block
    public string $street_po_box = '';

    public string $street_no = '';

    public string $block = '';

    public string $building_floor_room = '';

    public string $zip_code = '';

    public string $city = '';

    public string $county = '';

    public string $country = '';

    public string $state = '';

    public string $federal_tax_id = '';

    public string $gln = '';

    public string $tax_office = '';

    public string $address_name_2 = '';

    public string $address_name_3 = '';

    /** @var array<string, ?int> */
    public array $accountAssignments = [];

    public function mount(?int $warehouseId = null, string $mode = 'edit'): void
    {
        $this->mode = $mode;
        $this->warehouseId = $warehouseId;

        $this->initAccountAssignments();

        if ($mode === 'edit' && $warehouseId !== null) {
            $this->loadFromDb();
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
        $warehouse = Warehouse::with('glAccountAssignments')->find($this->warehouseId);
        if ($warehouse === null) {
            return;
        }

        $this->code = $warehouse->code ?? '';
        $this->name = $warehouse->name ?? '';
        $this->inactive = (bool) $warehouse->inactive;
        $this->drop_ship = (bool) $warehouse->drop_ship;
        $this->location = $warehouse->location ?? '';
        $this->nettable = (bool) $warehouse->nettable;
        $this->issue_part_for_maintenance = (bool) $warehouse->issue_part_for_maintenance;
        $this->enable_bin_locations = (bool) $warehouse->enable_bin_locations;

        $this->street_po_box = $warehouse->street_po_box ?? '';
        $this->street_no = $warehouse->street_no ?? '';
        $this->block = $warehouse->block ?? '';
        $this->building_floor_room = $warehouse->building_floor_room ?? '';
        $this->zip_code = $warehouse->zip_code ?? '';
        $this->city = $warehouse->city ?? '';
        $this->county = $warehouse->county ?? '';
        $this->country = $warehouse->country ?? '';
        $this->state = $warehouse->state ?? '';
        $this->federal_tax_id = $warehouse->federal_tax_id ?? '';
        $this->gln = $warehouse->gln ?? '';
        $this->tax_office = $warehouse->tax_office ?? '';
        $this->address_name_2 = $warehouse->address_name_2 ?? '';
        $this->address_name_3 = $warehouse->address_name_3 ?? '';

        foreach ($warehouse->glAccountAssignments as $assignment) {
            $this->accountAssignments[$assignment->account_type_key] = $assignment->gl_account_id !== null
                ? (int) $assignment->gl_account_id
                : null;
        }
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $this->validate([
            'code' => 'required|string|max:50|unique:warehouses,code,'.($this->warehouseId ?? 'NULL'),
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $payload = [
            'code' => $this->code,
            'name' => $this->name,
            'inactive' => $this->inactive,
            'drop_ship' => $this->drop_ship,
            'location' => $this->location ?: null,
            'nettable' => $this->nettable,
            'issue_part_for_maintenance' => $this->issue_part_for_maintenance,
            'enable_bin_locations' => $this->enable_bin_locations,
            'street_po_box' => $this->street_po_box ?: null,
            'street_no' => $this->street_no ?: null,
            'block' => $this->block ?: null,
            'building_floor_room' => $this->building_floor_room ?: null,
            'zip_code' => $this->zip_code ?: null,
            'city' => $this->city ?: null,
            'county' => $this->county ?: null,
            'country' => $this->country ?: null,
            'state' => $this->state ?: null,
            'federal_tax_id' => $this->federal_tax_id ?: null,
            'gln' => $this->gln ?: null,
            'tax_office' => $this->tax_office ?: null,
            'address_name_2' => $this->address_name_2 ?: null,
            'address_name_3' => $this->address_name_3 ?: null,
        ];

        if ($this->mode === 'create') {
            $warehouse = Warehouse::create($payload);
            $this->warehouseId = $warehouse->id;
            $this->mode = 'edit';
        } else {
            $warehouse = Warehouse::find($this->warehouseId);
            if ($warehouse === null) {
                return;
            }
            $warehouse->update($payload);
        }

        foreach ($this->accountAssignments as $key => $accountId) {
            if (! array_key_exists($key, GlAccountAssignment::ACCOUNT_TYPES)) {
                continue;
            }
            $warehouse->glAccountAssignments()->updateOrCreate(
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

        return view('livewire.admin.stock.warehouse-form', [
            'locationOptions' => array_combine(self::LOCATION_OPTIONS, self::LOCATION_OPTIONS),
            'accountTypes' => GlAccountAssignment::ACCOUNT_TYPES,
            'accounts' => $accounts,
        ]);
    }
}
