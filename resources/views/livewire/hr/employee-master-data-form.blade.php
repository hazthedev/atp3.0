@php
    $tabs = [
        ['id' => 'address', 'label' => 'Address'],
        ['id' => 'membership', 'label' => 'Membership'],
        ['id' => 'administration', 'label' => 'Administration'],
        ['id' => 'personal', 'label' => 'Personal'],
        ['id' => 'finance', 'label' => 'Finance'],
        ['id' => 'flight-ops', 'label' => 'Flight Ops'],
        ['id' => 'remarks', 'label' => 'Remarks'],
        ['id' => 'attachments', 'label' => 'Attachments'],
    ];
@endphp

<div x-data="{ editing: false, activeTab: 'address' }"
     x-on:record-saved.window="editing = false"
     class="space-y-6"
     data-edit-scope
     :data-editing="editing">

    <div class="flex flex-col items-start justify-between gap-4 lg:flex-row lg:items-start">
        <x-page-header
            title="Employee Master Data"
            description="Detail card for the selected employee. Click Edit Record to make changes."
        />
        <div class="flex flex-wrap items-center gap-3 lg:flex-shrink-0">
            <a href="{{ route('hr.employee-master-data') }}" class="btn-secondary">Back to list</a>
            <button type="button" class="btn-secondary" x-show="editing" @click="$dispatch('cancel-edit-form'); editing = false">Cancel</button>
            <button type="button" class="btn-primary" x-show="!editing" @click="editing = true">Edit Record</button>
            <button type="button" class="btn-primary" x-show="editing" @click="$dispatch('save-edit-form')">Save</button>
        </div>
    </div>

    <x-card padding="p-6">
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_220px]">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <x-enterprise.input wire:model="first_name" :disabled="false" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Employee No.</label>
                    <x-enterprise.input wire:model="employee_no" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <x-enterprise.input wire:model="middle_name" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Ext. Employee No.</label>
                    <x-enterprise.input wire:model="ext_employee_no" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <x-enterprise.input wire:model="last_name" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5 md:col-start-2">
                    <x-enterprise.checkbox label="Active Employee" wire:model="active_employee" inline x-bind:disabled="!editing" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Job Title</label>
                    <x-enterprise.input wire:model="job_title" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5"></div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Position</label>
                    <x-enterprise.input wire:model="position" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Office Phone</label>
                    <x-enterprise.input wire:model="office_phone" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Department</label>
                    <x-enterprise.input wire:model="department" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Ext.</label>
                    <x-enterprise.input wire:model="office_phone_ext" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Branch</label>
                    <x-enterprise.input wire:model="branch" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Mobile Phone</label>
                    <x-enterprise.input wire:model="mobile_phone" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Manager</label>
                    <x-enterprise.input wire:model="manager_id" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Pager</label>
                    <x-enterprise.input wire:model="pager" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">User Code</label>
                    <x-enterprise.input wire:model="user_code" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Home Phone</label>
                    <x-enterprise.input wire:model="home_phone" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Sales Employee</label>
                    <x-enterprise.input wire:model="sales_employee" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Fax</label>
                    <x-enterprise.input wire:model="fax" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Cost Center</label>
                    <x-enterprise.input wire:model="cost_center" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">E-Mail</label>
                    <x-enterprise.input type="email" wire:model="email" x-bind:disabled="!editing" />
                </div>
                <div class="space-y-1.5 md:col-start-2">
                    <label class="block text-sm font-medium text-gray-700">Linked Vendor</label>
                    <x-enterprise.input variant="lookup" wire:model="linked_vendor" x-bind:disabled="!editing" />
                </div>
            </div>

            <div class="flex items-start justify-center">
                <div class="aspect-square w-full max-w-[180px] rounded-xl border border-dashed border-gray-300 bg-gray-50/80 p-2 text-center text-xs text-gray-400 flex items-center justify-center">
                    Photo
                </div>
            </div>
        </div>
    </x-card>

    <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
        <div class="subtab-shell">
            <ul class="subtab-list">
                @foreach ($tabs as $tab)
                    <li class="subtab-item">
                        <button type="button" class="subtab-link"
                                :class="activeTab === '{{ $tab['id'] }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                @click="activeTab = '{{ $tab['id'] }}'">
                            {{ $tab['label'] }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Address tab --}}
    <div x-cloak x-show="activeTab === 'address'" class="space-y-6">
        <x-card padding="p-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-gray-900 underline-offset-2 underline decoration-1">Work Address</p>
                    @foreach ([
                        ['name' => 'work_street', 'label' => 'Street'],
                        ['name' => 'work_street_no', 'label' => 'Street No.'],
                        ['name' => 'work_block', 'label' => 'Block'],
                        ['name' => 'work_building_floor_room', 'label' => 'Building/Floor/Room'],
                        ['name' => 'work_zip_code', 'label' => 'Zip Code'],
                        ['name' => 'work_city', 'label' => 'City'],
                        ['name' => 'work_county', 'label' => 'County'],
                        ['name' => 'work_state', 'label' => 'State'],
                        ['name' => 'work_country', 'label' => 'Country'],
                    ] as $field)
                        <div class="grid grid-cols-[112px_minmax(0,1fr)] items-center gap-3">
                            <label class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                            <x-enterprise.input wire:model="{{ $field['name'] }}" x-bind:disabled="!editing" />
                        </div>
                    @endforeach
                </div>
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-gray-900 underline-offset-2 underline decoration-1">Home Address</p>
                    @foreach ([
                        ['name' => 'home_street', 'label' => 'Street'],
                        ['name' => 'home_street_no', 'label' => 'Street No.'],
                        ['name' => 'home_block', 'label' => 'Block'],
                        ['name' => 'home_building_floor_room', 'label' => 'Building/Floor/Room'],
                        ['name' => 'home_zip_code', 'label' => 'Zip Code'],
                        ['name' => 'home_city', 'label' => 'City'],
                        ['name' => 'home_county', 'label' => 'County'],
                        ['name' => 'home_state', 'label' => 'State'],
                        ['name' => 'home_country', 'label' => 'Country'],
                    ] as $field)
                        <div class="grid grid-cols-[112px_minmax(0,1fr)] items-center gap-3">
                            <label class="text-sm font-medium text-gray-600">{{ $field['label'] }}</label>
                            <x-enterprise.input wire:model="{{ $field['name'] }}" x-bind:disabled="!editing" />
                        </div>
                    @endforeach
                </div>
            </div>
        </x-card>
    </div>

    {{-- Membership tab --}}
    <div x-cloak x-show="activeTab === 'membership'">
        <x-card padding="p-6">
            @livewire('hr.employee-membership-form', ['employeeId' => $employeeId], key('employee-membership-form-'.$employeeId))
        </x-card>
    </div>

    {{-- Administration tab --}}
    <div x-cloak x-show="activeTab === 'administration'">
        <x-card padding="p-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-3">
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Start Date</label>
                        <x-enterprise.input type="date" wire:model="start_date" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <x-enterprise.select wire:model="status" x-bind:disabled="!editing">
                            <option value="">— select —</option>
                            @foreach (\App\Livewire\Hr\EmployeeMasterDataForm::STATUS_OPTIONS as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </x-enterprise.select>
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Termination Date</label>
                        <x-enterprise.input type="date" wire:model="termination_date" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Termination Reason</label>
                        <x-enterprise.input wire:model="termination_reason" x-bind:disabled="!editing" />
                    </div>
                </div>
                <div class="space-y-2">
                    <button type="button" class="btn-secondary w-full justify-center" disabled>Absence</button>
                    <button type="button" class="btn-secondary w-full justify-center" disabled>Education</button>
                    <button type="button" class="btn-secondary w-full justify-center" disabled>Reviews</button>
                    <button type="button" class="btn-secondary w-full justify-center" disabled>Previous Employment</button>
                    <button type="button" class="btn-secondary w-full justify-center" disabled>Time Sheet</button>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="grid grid-cols-[110px_minmax(0,1fr)_60px_140px_60px_140px] items-center gap-3">
                    <label class="text-sm font-medium text-gray-600">Reference 1</label>
                    <x-enterprise.input wire:model="reference_1" x-bind:disabled="!editing" />
                    <span class="text-sm text-gray-500">From</span>
                    <x-enterprise.input type="date" wire:model="reference_1_from" x-bind:disabled="!editing" />
                    <span class="text-sm text-gray-500">To</span>
                    <x-enterprise.input type="date" wire:model="reference_1_to" x-bind:disabled="!editing" />
                </div>
                <div class="grid grid-cols-[110px_minmax(0,1fr)_60px_140px_60px_140px] items-center gap-3">
                    <label class="text-sm font-medium text-gray-600">Reference 2</label>
                    <x-enterprise.input wire:model="reference_2" x-bind:disabled="!editing" />
                    <span class="text-sm text-gray-500">From</span>
                    <x-enterprise.input type="date" wire:model="reference_2_from" x-bind:disabled="!editing" />
                    <span class="text-sm text-gray-500">To</span>
                    <x-enterprise.input type="date" wire:model="reference_2_to" x-bind:disabled="!editing" />
                </div>
                <div class="grid grid-cols-[110px_minmax(0,1fr)] items-start gap-3">
                    <label class="pt-2 text-sm font-medium text-gray-600">Remarks</label>
                    <x-enterprise.textarea rows="3" wire:model="admin_remarks" x-bind:disabled="!editing" />
                </div>
                <div class="grid grid-cols-[110px_minmax(0,1fr)] items-center gap-3">
                    <label class="text-sm font-medium text-gray-600">Work Profile</label>
                    <x-enterprise.input wire:model="work_profile" x-bind:disabled="!editing" />
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" class="btn-secondary" disabled>Qualification</button>
                    <button type="button" class="btn-secondary" disabled>Medical Visits</button>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Personal tab --}}
    <div x-cloak x-show="activeTab === 'personal'">
        <x-card padding="p-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-3">
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Gender</label>
                        <x-enterprise.select wire:model="gender" x-bind:disabled="!editing">
                            <option value="">— select —</option>
                            @foreach (\App\Livewire\Hr\EmployeeMasterDataForm::GENDER_OPTIONS as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </x-enterprise.select>
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Date of Birth</label>
                        <x-enterprise.input type="date" wire:model="date_of_birth" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Country of Birth</label>
                        <x-enterprise.input wire:model="country_of_birth" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Marital Status</label>
                        <x-enterprise.select wire:model="marital_status" x-bind:disabled="!editing">
                            <option value="">— select —</option>
                            @foreach (\App\Livewire\Hr\EmployeeMasterDataForm::MARITAL_STATUS_OPTIONS as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </x-enterprise.select>
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">No. of Children</label>
                        <x-enterprise.input type="number" wire:model="number_of_children" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">ID No.</label>
                        <x-enterprise.input wire:model="id_no" x-bind:disabled="!editing" />
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Citizenship</label>
                        <x-enterprise.input wire:model="citizenship" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Passport No.</label>
                        <x-enterprise.input wire:model="passport_no" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Passport Expiration Date</label>
                        <x-enterprise.input type="date" wire:model="passport_expiration_date" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Passport Issue Date</label>
                        <x-enterprise.input type="date" wire:model="passport_issue_date" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Passport Issuer</label>
                        <x-enterprise.input wire:model="passport_issuer" x-bind:disabled="!editing" />
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Finance tab --}}
    <div x-cloak x-show="activeTab === 'finance'">
        <x-card padding="p-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-3">
                    <div class="grid grid-cols-[110px_minmax(0,1fr)_120px] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Salary</label>
                        <x-enterprise.input type="number" step="0.01" wire:model="salary_amount" x-bind:disabled="!editing" />
                        <x-enterprise.select wire:model="salary_period" x-bind:disabled="!editing">
                            <option value="">—</option>
                            @foreach (\App\Livewire\Hr\EmployeeMasterDataForm::PERIOD_OPTIONS as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </x-enterprise.select>
                    </div>
                    <div class="grid grid-cols-[110px_minmax(0,1fr)_120px] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Employee Costs</label>
                        <x-enterprise.input type="number" step="0.01" wire:model="employee_costs_amount" x-bind:disabled="!editing" />
                        <x-enterprise.select wire:model="employee_costs_period" x-bind:disabled="!editing">
                            <option value="">—</option>
                            @foreach (\App\Livewire\Hr\EmployeeMasterDataForm::PERIOD_OPTIONS as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </x-enterprise.select>
                    </div>
                </div>
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-gray-900 underline-offset-2 underline decoration-1">Bank Details</p>
                    <div class="grid grid-cols-[110px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Bank</label>
                        <x-enterprise.input wire:model="bank" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[110px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Account No.</label>
                        <x-enterprise.input wire:model="bank_account_no" x-bind:disabled="!editing" />
                    </div>
                    <div class="grid grid-cols-[110px_minmax(0,1fr)] items-center gap-3">
                        <label class="text-sm font-medium text-gray-600">Branch</label>
                        <x-enterprise.input wire:model="bank_branch" x-bind:disabled="!editing" />
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Flight Ops tab --}}
    <div x-cloak x-show="activeTab === 'flight-ops'">
        <x-card padding="p-6">
            <div class="grid grid-cols-[140px_minmax(0,1fr)] items-center gap-3 max-w-2xl">
                <label class="text-sm font-medium text-gray-600">Home base</label>
                <x-enterprise.input variant="lookup" wire:model="home_base" x-bind:disabled="!editing" />
            </div>

            <div class="mt-5">
                <x-empty-state
                    icon="paper-airplane"
                    label="Crew positions and assignments pending"
                    description="The Flight Ops Crew Management positions list and Employee Assignment editor land in a follow-up PR."
                />
            </div>
        </x-card>
    </div>

    {{-- Remarks tab --}}
    <div x-cloak x-show="activeTab === 'remarks'">
        <x-card padding="p-6">
            <x-enterprise.textarea
                wire:model="remarks"
                rows="14"
                class="min-h-[280px] bg-yellow-50/50"
                placeholder="Free-form remarks for this employee..."
                x-bind:disabled="!editing"
            ></x-enterprise.textarea>
        </x-card>
    </div>

    {{-- Attachments tab --}}
    <div x-cloak x-show="activeTab === 'attachments'">
        <x-card padding="p-6">
            <x-empty-state
                icon="paper-clip"
                label="Attachments editor pending"
                description="Attachments table + Browse / Display / Delete actions land in a follow-up PR."
            />
        </x-card>
    </div>

</div>
