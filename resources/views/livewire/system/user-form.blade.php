<div x-data="editMode({{ $mode === 'create' ? 'true' : 'false' }})" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
    <div class="space-y-6">
        <x-page-header
            :title="$mode === 'create' ? 'Create User' : ($user_code !== '' ? $user_code . ' — ' . $name : 'User Details')"
            :description="$mode === 'create' ? 'Provision a new user for the ATP 3.0 workspace.' : 'Maintain this user\'s profile, service preferences, and display options.'"
        >
            <x-slot name="actions">
                <a href="{{ route('system.user-management.index') }}" class="btn-secondary">
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

        <x-card padding="p-6">
            <div class="flex flex-wrap items-center gap-6 border-b border-gray-200 pb-4">
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                    <input type="checkbox" wire:model="is_superuser" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    Superuser
                </label>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                    <input type="checkbox" wire:model="is_mobile_user" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    Mobile User
                </label>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                    <input type="checkbox" wire:model="is_group" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    Group
                </label>
            </div>

            <div class="grid gap-4 pt-4 md:grid-cols-3">
                <div class="space-y-1.5">
                    <x-form.label for="user_code" :required="true">User Code</x-form.label>
                    <x-enterprise.input id="user_code" wire:model="user_code" />
                    @error('user_code') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <x-form.label for="user_name">User Name</x-form.label>
                    <x-enterprise.input id="user_name" wire:model="name" />
                    @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <x-form.label for="defaults">Defaults</x-form.label>
                    <x-enterprise.input id="defaults" wire:model="defaults" />
                </div>
            </div>
        </x-card>

        {{-- Tabs --}}
        <x-card padding="p-0">
            <div class="flex flex-wrap gap-x-6 border-b border-gray-200 px-5 pt-3">
                @foreach (['general' => 'General', 'services' => 'Services', 'display' => 'Display'] as $key => $label)
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
                            <x-form.label for="ms_windows_account">Bind with Microsoft Windows Account</x-form.label>
                            <x-enterprise.input id="ms_windows_account" wire:model="ms_windows_account" />
                        </div>
                        <div class="space-y-1.5">
                            <x-form.label for="email">E-Mail</x-form.label>
                            <x-enterprise.input id="email" type="email" wire:model="email" />
                            @error('email') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Employee: SAP shows right-side picker → lookup variant --}}
                        <div class="space-y-1.5">
                            <x-form.label for="employee">Employee</x-form.label>
                            <x-enterprise.input id="employee" wire:model="employee" variant="lookup" />
                        </div>
                        <div class="space-y-1.5">
                            <x-form.label for="mobile_phone">Mobile Phone</x-form.label>
                            <x-enterprise.input id="mobile_phone" wire:model="mobile_phone" />
                        </div>

                        <div class="space-y-1.5">
                            <x-form.label for="mobile_device_id">Mobile Device ID</x-form.label>
                            <x-enterprise.input id="mobile_device_id" wire:model="mobile_device_id" />
                        </div>
                        <div class="space-y-1.5">
                            <x-form.label for="fax">Fax</x-form.label>
                            <x-enterprise.input id="fax" wire:model="fax" />
                        </div>

                        {{-- Branch and Department: SAP shows dropdowns --}}
                        <x-form.select
                            id="branch"
                            name="branch"
                            label="Branch"
                            placeholder="Select branch"
                            wire:model="branch"
                            :options="array_combine($branchOptions, $branchOptions)"
                        />
                        <x-form.select
                            id="department"
                            name="department"
                            label="Department"
                            placeholder="Select department"
                            wire:model="department"
                            :options="array_combine($departmentOptions, $departmentOptions)"
                        />

                        {{-- Groups: SAP-literal single-picker with lookup variant --}}
                        <div class="space-y-1.5 md:col-span-2">
                            <x-form.label for="groups_display">Groups</x-form.label>
                            <x-enterprise.input
                                id="groups_display"
                                :value="$this->selectedGroupName()"
                                readonly
                                placeholder="Click the lookup icon to pick a group…"
                                variant="lookup"
                            >
                                <x-slot name="lookupAction">
                                    <button
                                        type="button"
                                        wire:click="openGroupPicker"
                                        data-edit-locked="true"
                                        x-bind:disabled="!editing"
                                        class="flex items-center justify-center text-gray-400 transition-colors hover:text-gray-700 focus:outline-none disabled:opacity-40 disabled:cursor-not-allowed"
                                    >
                                        <x-icon name="magnifying-glass" class="h-4 w-4" />
                                    </button>
                                </x-slot>
                            </x-enterprise.input>
                            @if ($selectedGroupId !== null)
                                <p class="text-xs text-gray-500">
                                    Additional memberships can be managed from the User Groups page.
                                </p>
                            @endif
                        </div>

                        {{-- Password: SAP shows ... picker → lookup variant (stub, clicking does nothing for now) --}}
                        <div class="space-y-1.5 md:col-span-2">
                            <x-form.label for="password_input">Password</x-form.label>
                            <x-enterprise.input
                                id="password_input"
                                type="password"
                                wire:model="password_input"
                                variant="lookup"
                                placeholder="{{ $mode === 'create' ? 'Leave blank for default password' : 'Leave blank to keep current' }}"
                            />
                        </div>

                        <div class="md:col-span-2 grid gap-3 md:grid-cols-2">
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="password_never_expires" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Password Never Expires
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="change_password_next_logon" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Change Password at Next Logon
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="is_locked" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Locked
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="enable_integration_packages" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                Enable Setting Integration Packages
                            </label>
                        </div>
                    </div>
                @elseif ($tab === 'services')
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">At the Beginning of Each Session</h4>
                            <div class="mt-3 grid gap-2 md:grid-cols-2">
                                @foreach ([
                                    'perform_data_check' => 'Perform Data Check',
                                    'open_exchange_rates' => 'Open Exchange Rates Table',
                                    'display_recurring_postings' => 'Display Recurring Postings on Execution',
                                    'display_recurring_transactions' => 'Display Recurring Transactions on Execution',
                                    'send_alert_activities' => 'Send Alert for Activities Scheduled for Today',
                                    'display_inbox' => 'Display Inbox When New Message Arrives',
                                    'open_credit_voucher' => 'Open Window for Credit Voucher Ref. Update',
                                    'open_postdated_checks' => 'Open Postdated Checks Window',
                                    'display_worklist' => 'Display Worklist When New Task Arrives',
                                ] as $key => $label)
                                    <label class="flex items-center gap-2 text-sm text-gray-700">
                                        <input type="checkbox" wire:model="services.{{ $key }}" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3 border-t border-gray-200 pt-5">
                            <div class="space-y-1.5">
                                <x-form.label for="update_messages_min">Update Messages (Min.)</x-form.label>
                                <x-enterprise.input id="update_messages_min" type="number" wire:model="services.update_messages_min" />
                            </div>
                            <div class="space-y-1.5">
                                <x-form.label for="screen_locking_time_min">Screen Locking Time (Min.)</x-form.label>
                                <x-enterprise.input id="screen_locking_time_min" type="number" wire:model="services.screen_locking_time_min" />
                            </div>
                            <x-form.select
                                id="open_postdated_credit_vouchers"
                                name="open_postdated_credit_vouchers"
                                label="Open Postdated Credit Vouchers Window"
                                placeholder="—"
                                wire:model="services.open_postdated_credit_vouchers"
                                :options="['No' => 'No', 'Yes' => 'Yes']"
                            />
                        </div>

                        <div class="border-t border-gray-200 pt-5">
                            <h4 class="text-sm font-semibold text-gray-900">Alternative Keyboard Usage</h4>
                            <div class="mt-3 space-y-2">
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" wire:model="services.kbd_numeric_enter_as_tab" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                    Use Numeric Keypad Enter Key as Tab Key
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" wire:model="services.kbd_numeric_period_as_separator" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                    Use Numeric Keypad Period Key as Separator on Display Tab
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" wire:model="services.kbd_enable_document_ops_mouse_only" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                    Enable Document Operations by Mouse Only (Such as Add, Update, OK)
                                </label>
                            </div>
                        </div>
                    </div>
                @elseif ($tab === 'display')
                    <div class="grid gap-5 md:grid-cols-2">
                        @foreach ([
                            'skin_style' => ['label' => 'Skin Style', 'options' => ['Default', 'Classic', 'Modern']],
                            'color' => ['label' => 'Color', 'options' => ['Blue', 'Green', 'Gray']],
                            'language' => ['label' => 'Language', 'options' => ['English', 'Bahasa Malaysia', 'Chinese']],
                            'font' => ['label' => 'Font', 'options' => ['Arial', 'Segoe UI', 'Inter', 'Roboto']],
                            'font_size' => ['label' => 'Font Size', 'options' => ['Small', 'Medium', 'Large']],
                            'background' => ['label' => 'Background', 'options' => ['None', 'Weststar 1', 'Weststar 2']],
                            'image_display' => ['label' => 'Image Display', 'options' => ['Center', 'Stretch', 'Tile']],
                            'ext_image_processing' => ['label' => 'Ext. Image Processing', 'options' => ['Enabled', 'Disabled']],
                        ] as $key => $meta)
                            <x-form.select
                                :id="$key"
                                :name="$key"
                                :label="$meta['label']"
                                placeholder="—"
                                wire:model="display.{{ $key }}"
                                :options="array_combine($meta['options'], $meta['options'])"
                            />
                        @endforeach
                    </div>

                    <div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <p class="text-xs text-gray-500">Preview</p>
                        <p class="mt-2 text-lg font-medium text-gray-800" style="font-family: {{ $display['font'] ?? 'inherit' }};">AaBbYyZz — abcd</p>
                    </div>
                @endif
            </div>
        </x-card>
    </div>

    {{-- Group picker modal --}}
    @if ($groupPickerOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4" wire:click.self="closeGroupPicker">
            <div class="w-full max-w-md rounded-xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">Pick a Group</h3>
                    <button type="button" wire:click="closeGroupPicker" class="text-gray-400 hover:text-gray-700">
                        <x-icon name="chevron-right" class="h-4 w-4 rotate-45" />
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto">
                    <button type="button" wire:click="chooseGroup(null)" class="flex w-full items-center justify-between border-b border-gray-100 px-5 py-2.5 text-left text-sm text-gray-600 hover:bg-blue-50">
                        <span class="italic">— Clear selection —</span>
                    </button>
                    @foreach ($groupOptions as $opt)
                        <button
                            type="button"
                            wire:click="chooseGroup({{ $opt['id'] }})"
                            class="flex w-full items-center justify-between border-b border-gray-100 px-5 py-2.5 text-left text-sm transition hover:bg-blue-50 {{ $selectedGroupId === (int) $opt['id'] ? 'bg-blue-50 font-semibold text-blue-700' : 'text-gray-700' }}"
                        >
                            <span>{{ $opt['name'] }}</span>
                            @if ($selectedGroupId === (int) $opt['id'])
                                <x-icon name="check" class="h-4 w-4 text-blue-600" />
                            @endif
                        </button>
                    @endforeach
                </div>
                <div class="flex justify-end border-t border-gray-200 px-5 py-3">
                    <button type="button" wire:click="closeGroupPicker" class="btn-secondary">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
