<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\MinimumEquipmentListCatalog;
use Livewire\Component;

class MinimumEquipmentListPage extends Component
{
    public string $scope = 'functional-location';

    public string $status = '0000014';

    public string $lookupSearch = '';

    public bool $lookupModalOpen = false;

    public ?string $pendingLookupId = null;

    /**
     * @var array<string, string>
     */
    public array $form = [];

    /**
     * @var array<int, array<string, string>>
     */
    public array $items = [];

    public bool $loaded = false;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->resetPreview();
    }

    public function updatedScope(): void
    {
        $this->resetPreview();
    }

    public function updatedStatus(): void
    {
        if ($this->loaded) {
            $this->fillPreview();
        }
    }

    public function openLookupModal(): void
    {
        $this->lookupModalOpen = true;
        $this->lookupSearch = '';
        $this->pendingLookupId = null;
    }

    public function closeLookupModal(): void
    {
        $this->lookupModalOpen = false;
        $this->lookupSearch = '';
        $this->pendingLookupId = null;
    }

    public function selectLookupRow(string $id): void
    {
        $this->pendingLookupId = $id;
    }

    public function chooseLookupRow(): void
    {
        $row = MinimumEquipmentListCatalog::findLookup($this->pendingLookupId);

        if ($row === null) {
            $this->setStatus('Select a MEL record from the list first.', 'amber');

            return;
        }

        if ($this->scope === 'equipment') {
            $this->form['equipment_no'] = $row['equipment_code'];
            $this->form['internal_sn'] = $row['internal_sn'];
            $this->form['item_code'] = $row['item_code'];
            $this->form['variant'] = $row['variant'];
        } else {
            $this->form['code'] = $row['fl_code'];
            $this->form['serial_number'] = $row['serial_number'];
            $this->form['registration'] = $row['registration'];
            $this->form['type'] = $row['type'];
        }

        $this->form['mmel'] = $row['mmel'];
        $this->form['title'] = $row['title'];

        $this->fillPreview();
        $this->loaded = true;
        $this->closeLookupModal();
        $this->setStatus('Minimum Equipment List preview loaded.', 'green');
    }

    public function cancelPreview(): void
    {
        $this->resetPreview();
        $this->setStatus('Minimum Equipment List preview reset.', 'blue');
    }

    public function checkOperationalStatus(): void
    {
        $this->setStatus('Operational status check preview opened.', 'amber');
    }

    public function addItemPreview(): void
    {
        $this->setStatus('Add Item preview opened.', 'blue');
    }

    public function displayItemPreview(): void
    {
        $this->setStatus('Display Item preview opened.', 'blue');
    }

    public function render()
    {
        return view('livewire.fleet.minimum-equipment-list-page', [
            'statusOptions' => MinimumEquipmentListCatalog::statusOptions(),
            'lookupRows' => MinimumEquipmentListCatalog::searchLookup($this->lookupSearch),
            'leftFields' => $this->scope === 'equipment'
                ? [
                    ['key' => 'equipment_no', 'label' => 'Equipment No.', 'lookup' => true, 'highlight' => true],
                    ['key' => 'internal_sn', 'label' => 'Internal S/N'],
                    ['key' => 'item_code', 'label' => 'Item Code'],
                    ['key' => 'variant', 'label' => 'Variant'],
                ]
                : [
                    ['key' => 'code', 'label' => 'Code', 'lookup' => true, 'highlight' => true],
                    ['key' => 'serial_number', 'label' => 'Serial Number'],
                    ['key' => 'registration', 'label' => 'Registration'],
                    ['key' => 'type', 'label' => 'Type'],
                ],
            'metaFields' => [
                ['key' => 'revision_number', 'label' => 'Revision Number', 'highlight' => true],
                ['key' => 'revision_date', 'label' => 'Revision Date', 'highlight' => true],
                ['key' => 'create_date', 'label' => 'Create Date'],
                ['key' => 'created_by', 'label' => 'Created By'],
                ['key' => 'update_date', 'label' => 'Update Date'],
                ['key' => 'updated_by', 'label' => 'Updated By'],
            ],
        ]);
    }

    private function fillPreview(): void
    {
        $preview = MinimumEquipmentListCatalog::preview($this->scope, $this->status);

        foreach ($preview as $key => $value) {
            $this->form[$key] = $value;
        }

        $this->items = MinimumEquipmentListCatalog::items($this->scope)->all();
    }

    private function resetPreview(): void
    {
        $this->loaded = false;
        $this->items = [];
        $this->lookupSearch = '';
        $this->pendingLookupId = null;
        $this->lookupModalOpen = false;
        $this->form = [
            'code' => '',
            'serial_number' => '',
            'registration' => '',
            'type' => '',
            'equipment_no' => '',
            'internal_sn' => '',
            'item_code' => '',
            'variant' => '',
            'mmel' => '',
            'title' => '',
            'revision_number' => '',
            'revision_date' => '',
            'create_date' => '',
            'created_by' => '',
            'update_date' => '',
            'updated_by' => '',
        ];
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
