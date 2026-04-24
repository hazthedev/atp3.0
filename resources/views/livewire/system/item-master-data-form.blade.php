<div class="grid gap-4 md:grid-cols-2">
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Item No.</label>
        <x-enterprise.input wire:model="code" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <x-enterprise.input wire:model="description" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Manufacturer</label>
        <x-enterprise.input wire:model="manufacturer" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Item Group</label>
        <x-enterprise.input wire:model="item_group" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Item Class</label>
        <x-enterprise.input wire:model="item_class" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">Item Type</label>
        <x-enterprise.input wire:model="item_type" />
    </div>
    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">UoM Group</label>
        <x-enterprise.input wire:model="uom_group" />
    </div>
</div>
