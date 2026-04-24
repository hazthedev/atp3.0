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
                    <label class="text-sm font-medium text-gray-700">User Code</label>
                    <input type="text" wire:model="user_code" class="input-field" />
                    @error('user_code') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-gray-700">User Name</label>
                    <input type="text" wire:model="name" class="input-field" />
                    @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-gray-700">Defaults</label>
                    <input type="text" wire:model="defaults" class="input-field" />
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
                            <label class="text-sm font-medium text-gray-700">Bind with Microsoft Windows Account</label>
                            <input type="text" wire:model="ms_windows_account" class="input-field" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">E-Mail</label>
                            <input type="email" wire:model="email" class="input-field" />
                            @error('email') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Employee</label>
                            <input type="text" wire:model="employee" class="input-field" placeholder="(free text — will become picker later)" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Mobile Phone</label>
                            <input type="text" wire:model="mobile_phone" class="input-field" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Mobile Device ID</label>
                            <input type="text" wire:model="mobile_device_id" class="input-field" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Fax</label>
                            <input type="text" wire:model="fax" class="input-field" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Branch</label>
                            <input type="text" wire:model="branch" class="input-field" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Department</label>
                            <input type="text" wire:model="department" class="input-field" />
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Groups</label>
                            <div class="flex flex-wrap gap-2 rounded-lg border border-gray-200 bg-gray-50 p-3">
                                @forelse ($groupOptions as $opt)
                                    @php $isSelected = in_array($opt['id'], $selectedGroupIds, true); @endphp
                                    <button
                                        type="button"
                                        wire:click="toggleGroup({{ $opt['id'] }})"
                                        data-edit-locked="true"
                                        x-bind:disabled="!editing"
                                        class="inline-flex items-center gap-1 rounded-full border px-3 py-1 text-xs font-medium transition {{ $isSelected ? 'border-blue-300 bg-blue-50 text-blue-700' : 'border-gray-200 bg-white text-gray-600 hover:border-blue-200 hover:text-blue-700' }}"
                                    >
                                        @if ($isSelected)
                                            <x-icon name="check" class="h-3 w-3" />
                                        @endif
                                        {{ $opt['name'] }}
                                    </button>
                                @empty
                                    <span class="text-xs text-gray-400">No groups defined.</span>
                                @endforelse
                            </div>
                            <p class="text-xs text-gray-500">Click chips to toggle membership (available only in edit mode).</p>
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Password</label>
                            <input type="password" wire:model="password_input" class="input-field max-w-md" placeholder="{{ $mode === 'create' ? 'Leave blank for default "password"' : 'Leave blank to keep current' }}" />
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
                                <label class="text-sm font-medium text-gray-700">Update Messages (Min.)</label>
                                <input type="number" wire:model="services.update_messages_min" class="input-field" />
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Screen Locking Time (Min.)</label>
                                <input type="number" wire:model="services.screen_locking_time_min" class="input-field" />
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Open Postdated Credit Vouchers Window</label>
                                <select wire:model="services.open_postdated_credit_vouchers" class="input-field">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
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
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">{{ $meta['label'] }}</label>
                                <select wire:model="display.{{ $key }}" class="input-field">
                                    <option value="">—</option>
                                    @foreach ($meta['options'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
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
</div>
