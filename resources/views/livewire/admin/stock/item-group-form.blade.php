<div x-data="editMode({{ $mode === 'create' ? 'true' : 'false' }})" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
    <div class="space-y-6">
        <x-page-header
            :title="$mode === 'create' ? 'Create Item Group' : ($name !== '' ? $name : 'Item Group')"
            :description="$mode === 'create' ? 'Define a new item group with default UoM, valuation method, and per-warehouse bin defaults.' : 'Maintain this item group\'s general settings, bin defaults, and G/L account mapping.'"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.stock-management.item-groups') }}" class="btn-secondary">
                    <x-icon name="chevron-right" class="h-4 w-4 rotate-180" />
                    Back to List
                </a>
                @if ($mode === 'edit')
                    <template x-if="!editing">
                        <button type="button" class="btn-primary" @click="enter()">Edit Record</button>
                    </template>
                @endif
                <template x-if="editing">
                    <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-primary" @click="save()">Save</button>
                </template>
            </x-slot>
        </x-page-header>

        {{-- Header row: Item Group Name --}}
        <x-card padding="p-6">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-1.5 md:col-span-2">
                    <x-form.label for="name" :required="true">Item Group Name</x-form.label>
                    <x-enterprise.input id="name" wire:model="name" />
                    @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </x-card>

        {{-- Tabs --}}
        <x-card padding="p-0">
            <div class="flex flex-wrap gap-x-6 border-b border-gray-200 px-5 pt-3">
                @foreach (['general' => 'General', 'accounting' => 'Accounting'] as $key => $label)
                    <button
                        type="button"
                        wire:click="setTab('{{ $key }}')"
                        data-edit-locked="true"
                        class="inline-flex items-center border-b-2 px-1 pb-3 pt-2 text-sm font-medium transition {{ $tab === $key ? 'border-[#2f5bff] text-[#2f5bff]' : 'border-transparent text-slate-500 hover:border-[#9fb2ff] hover:text-[#2f5bff]' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="p-6">
                @if ($tab === 'general')
                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="space-y-1.5">
                            <x-form.label for="default_uom_group">Default UoM Group</x-form.label>
                            <x-enterprise.input id="default_uom_group" wire:model="default_uom_group" />
                        </div>
                        <div class="space-y-1.5">
                            <x-form.label for="lead_time_days">Lead Time (Days)</x-form.label>
                            <x-enterprise.input id="lead_time_days" type="number" min="0" wire:model="lead_time_days" />
                            @error('lead_time_days') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <x-form.select
                            id="default_valuation_method"
                            name="default_valuation_method"
                            label="Default Valuation Method"
                            placeholder="Select valuation method"
                            wire:model="default_valuation_method"
                            :options="$valuationMethods"
                        />
                    </div>

                    <div class="mt-8">
                        <h3 class="mb-3 text-sm font-semibold text-gray-700">Default Bin Locations</h3>
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="table-th w-12">#</th>
                                        <th class="table-th">Whse Code</th>
                                        <th class="table-th">Whse Name</th>
                                        <th class="table-th">Default Bin Location</th>
                                        <th class="table-th w-48">Enforce Default Bin Loc.</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse ($binDefaults as $warehouseId => $row)
                                        <tr>
                                            <td class="table-td text-gray-500">{{ $loop->iteration }}</td>
                                            <td class="table-td font-medium text-gray-900">{{ $row['warehouse_code'] }}</td>
                                            <td class="table-td text-gray-700">{{ $row['warehouse_name'] }}</td>
                                            <td class="table-td">
                                                <x-enterprise.input wire:model="binDefaults.{{ $warehouseId }}.default_bin_location" />
                                            </td>
                                            <td class="table-td">
                                                <input type="checkbox" wire:model="binDefaults.{{ $warehouseId }}.enforce" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="table-td text-center text-gray-400">No warehouses defined.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    {{-- Accounting tab --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="table-th w-12">#</th>
                                    <th class="table-th w-80 text-[#2f5bff]">Account Type</th>
                                    <th class="table-th">Account Code</th>
                                    <th class="table-th">Account Name</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @php($rowIndex = 0)
                                @foreach ($accountTypes as $key => $label)
                                    @php($rowIndex++)
                                    @php($selectedId = $accountAssignments[$key] ?? null)
                                    @php($selectedAccount = $selectedId !== null ? $accounts->firstWhere('id', $selectedId) : null)
                                    <tr>
                                        <td class="table-td text-gray-500">{{ $rowIndex }}</td>
                                        <td class="table-td font-medium text-[#2f5bff]">{{ $label }}</td>
                                        <td class="table-td">
                                            <select wire:model.live="accountAssignments.{{ $key }}" class="input-field">
                                                <option value="">—</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">{{ $account->code }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="table-td text-gray-700">{{ $selectedAccount?->name ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </x-card>
    </div>
</div>
