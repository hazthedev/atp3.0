<div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-700">Chapter</label>
            <x-enterprise.input wire:model="chapter" />
        </div>
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-700">Section</label>
            <x-enterprise.input wire:model="section" />
        </div>
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-700">Subject</label>
            <x-enterprise.input wire:model="subject" />
        </div>
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-700">Sheet</label>
            <x-enterprise.input wire:model="sheet" />
        </div>
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-700">Mark</label>
            <x-enterprise.input variant="indicator" tone="green" wire:model="mark" />
        </div>
    </div>

    <div class="space-y-1.5">
        <label class="block text-sm font-medium text-gray-700">MEL Item</label>
        <x-enterprise.input variant="lookup" wire:model="mel_item" />
    </div>
</div>
