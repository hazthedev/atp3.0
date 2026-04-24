<div x-data="editMode({{ $mode === 'create' ? 'true' : 'false' }})" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
    <div class="space-y-6">
        <x-page-header
            :title="$mode === 'create' ? 'Create Warehouse' : ($code !== '' ? $code . ' — ' . $name : 'Warehouse')"
            :description="$mode === 'create' ? 'Register a new warehouse with its address, flags, and G/L account mapping.' : 'Maintain this warehouse\'s address details, flags, and G/L account mapping.'"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.stock-management.warehouses') }}" class="btn-secondary">
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

        {{-- Header row --}}
        <x-card padding="p-6">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1.5">
                    <x-form.label for="code" :required="true">Warehouse Code</x-form.label>
                    <x-enterprise.input id="code" wire:model="code" />
                    @error('code') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <x-form.label for="name" :required="true">Warehouse Name</x-form.label>
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
                        {{-- Left column: flags + location --}}
                        <div class="space-y-4">
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="inactive" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Inactive
                            </label>
                            <x-form.select
                                id="location"
                                name="location"
                                label="Location"
                                placeholder="Select location"
                                wire:model="location"
                                :options="$locationOptions"
                            />
                        </div>

                        {{-- Right column: operational flags --}}
                        <div class="space-y-4">
                            <label class="flex items-center gap-2 text-sm text-gray-400">
                                <input type="checkbox" wire:model="drop_ship" disabled data-edit-locked="true" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Drop-Ship
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="nettable" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Nettable
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="issue_part_for_maintenance" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Issue part for maintenance
                            </label>
                        </div>
                    </div>

                    {{-- Address block --}}
                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <div class="space-y-3">
                            @foreach ([
                                'street_po_box' => 'Street/PO Box',
                                'street_no' => 'Street No.',
                                'block' => 'Block',
                                'building_floor_room' => 'Building/Floor/Room',
                                'zip_code' => 'Zip Code',
                                'city' => 'City',
                                'county' => 'County',
                            ] as $field => $label)
                                <div class="grid grid-cols-3 items-center gap-3">
                                    <x-form.label :for="$field" class="text-[#2f5bff]">{{ $label }}</x-form.label>
                                    <div class="col-span-2">
                                        <x-enterprise.input :id="$field" wire:model="{{ $field }}" />
                                    </div>
                                </div>
                            @endforeach

                            <div class="grid grid-cols-3 items-center gap-3">
                                <x-form.label for="country" class="text-[#2f5bff]">Country</x-form.label>
                                <div class="col-span-2">
                                    <x-enterprise.input id="country" wire:model="country" variant="lookup" />
                                </div>
                            </div>

                            <div class="grid grid-cols-3 items-center gap-3">
                                <x-form.label for="state" class="text-[#2f5bff]">State</x-form.label>
                                <div class="col-span-2">
                                    <x-enterprise.input id="state" wire:model="state" />
                                </div>
                            </div>

                            @foreach ([
                                'federal_tax_id' => 'Federal Tax ID',
                                'gln' => 'GLN',
                                'tax_office' => 'Tax Office',
                                'address_name_2' => 'Address Name 2',
                                'address_name_3' => 'Address Name 3',
                            ] as $field => $label)
                                <div class="grid grid-cols-3 items-center gap-3">
                                    <x-form.label :for="$field" class="text-[#2f5bff]">{{ $label }}</x-form.label>
                                    <div class="col-span-2">
                                        <x-enterprise.input :id="$field" wire:model="{{ $field }}" />
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="enable_bin_locations" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Enable Bin Locations
                            </label>
                            <div class="pt-2">
                                <a href="#" data-edit-locked="true" class="text-sm font-medium text-blue-600 hover:underline">Show Location in Web Browser</a>
                            </div>
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
