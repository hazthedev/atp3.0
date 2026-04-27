<div class="grid gap-4 md:grid-cols-2">
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Equipment No.</label>
        <x-enterprise.input variant="indicator" tone="green" wire:model="equipment_no" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <x-enterprise.select wire:model="status">
            <option value="">— select —</option>
            @foreach (\App\Livewire\Fleet\EquipmentShowForm::STATUS_OPTIONS as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </x-enterprise.select>
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Serial Number</label>
        <x-enterprise.input variant="tree" wire:model="serial_number" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Owner Name</label>
        <x-enterprise.input wire:model="owner_name" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Item No.</label>
        <x-enterprise.input variant="arrow-lookup" wire:model="item_no" readonly />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Operator Name</label>
        <x-enterprise.input variant="lookup" wire:model="operator_name" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Item Description</label>
        <x-enterprise.input wire:model="item_description" readonly />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Maintenance Plan</label>
        <x-enterprise.input variant="indicator" tone="green" wire:model="maintenance_plan" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Category Part</label>
        <x-enterprise.input variant="lookup" wire:model="category_part" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Variant</label>
        <x-enterprise.input variant="lookup" wire:model="variant" />
    </div>
</div>
