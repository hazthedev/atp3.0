<div class="grid gap-4 md:grid-cols-2">
    <div class="space-y-1.5">
        <x-form.label for="fl_code">Code</x-form.label>
        <x-enterprise.input id="fl_code" wire:model="code" variant="indicator" tone="green" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_status">Status</x-form.label>
        <x-form.select
            id="fl_status"
            wire:model="status"
            :options="[
                '-0000007' => '-0000007 - Airworthy',
                '-0000008' => '-0000008 - In Repair',
                'OTS' => 'OTS - Out of Service',
            ]"
        />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_serial_no">Serial No.</x-form.label>
        <x-enterprise.input id="fl_serial_no" wire:model="serial_no" variant="tree" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_maintenance_plan">Maintenance Plan</x-form.label>
        <x-enterprise.input id="fl_maintenance_plan" wire:model="maintenance_plan" variant="arrow-indicator" tone="green" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_registration">Registration</x-form.label>
        <x-enterprise.input id="fl_registration" wire:model="registration" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_owner_code">Owner Code</x-form.label>
        <x-enterprise.input id="fl_owner_code" wire:model="owner_code" variant="arrow-lookup" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_type">Type</x-form.label>
        <x-enterprise.input id="fl_type" wire:model="type" variant="arrow-lookup" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_owner_name">Owner Name</x-form.label>
        <x-enterprise.input id="fl_owner_name" wire:model="owner_name" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_mel">MEL</x-form.label>
        <x-enterprise.input id="fl_mel" wire:model="mel" variant="indicator" tone="green" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_operator_code">Operator Code</x-form.label>
        <x-enterprise.input id="fl_operator_code" wire:model="operator_code" variant="arrow-lookup" />
    </div>
    <div class="space-y-1.5">
        <x-form.label for="fl_operator_name">Operator Name</x-form.label>
        <x-enterprise.input id="fl_operator_name" wire:model="operator_name" />
    </div>
</div>
