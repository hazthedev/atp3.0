<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\FunctionalLocation;
use Livewire\Attributes\On;
use Livewire\Component;

class FunctionalLocationShowForm extends Component
{
    public int $flId;

    public string $code = '';
    public string $serial_no = '';
    public string $registration = '';
    public string $type = '';
    public string $status = '';
    public string $maintenance_plan = '';
    public string $owner_code = '';
    public string $owner_name = '';
    public string $operator_code = '';
    public string $operator_name = '';
    public string $mel = '';

    public function mount(int $flId): void
    {
        $this->flId = $flId;
        $this->loadFromDb();
    }

    private function loadFromDb(): void
    {
        $fl = FunctionalLocation::find($this->flId);

        if ($fl === null) {
            return;
        }

        $this->code = $fl->code ?? '';
        $this->serial_no = $fl->serial_no ?? '';
        $this->registration = $fl->registration ?? '';
        $this->type = $fl->type ?? '';
        $this->status = $fl->status ?? '';
        $this->maintenance_plan = $fl->maintenance_plan ?? '';
        $this->owner_code = $fl->owner_code ?? '';
        $this->owner_name = $fl->owner_name ?? '';
        $this->operator_code = $fl->operator_code ?? '';
        $this->operator_name = $fl->operator_name ?? '';
        $this->mel = $fl->mel ?? '';
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $fl = FunctionalLocation::find($this->flId);

        if ($fl === null) {
            return;
        }

        $fl->update([
            'code' => $this->code,
            'serial_no' => $this->serial_no ?: null,
            'registration' => $this->registration ?: null,
            'type' => $this->type ?: null,
            'status' => $this->status ?: 'Airworthy',
            'maintenance_plan' => $this->maintenance_plan ?: null,
            'owner_code' => $this->owner_code ?: null,
            'owner_name' => $this->owner_name ?: null,
            'operator_code' => $this->operator_code ?: null,
            'operator_name' => $this->operator_name ?: null,
            'mel' => $this->mel ?: null,
        ]);

        $this->dispatch('record-saved');
    }

    #[On('cancel-edit-form')]
    public function cancelEdit(): void
    {
        $this->loadFromDb();
        $this->dispatch('record-saved');
    }

    public function render()
    {
        return view('livewire.fleet.functional-location-show-form');
    }
}
