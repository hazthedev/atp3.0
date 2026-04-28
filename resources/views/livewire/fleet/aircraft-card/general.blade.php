@php
    $g = $data['general'];
    $isEdit = $editMode;
@endphp

<section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm" data-edit-scope>
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-900">General Information</h3>
        @if (! $isEdit)
            <button type="button" wire:click="enableEdit"
                    class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                <x-icon name="pencil-square" class="h-4 w-4" />
                Edit Record
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- 1. Aircraft Lifecycle --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="calendar-days" class="h-4 w-4 text-blue-600" />
                <span>1. Aircraft Lifecycle</span>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-enterprise.label>Date of Manufacture (DOM)</x-enterprise.label>
                    <x-enterprise.input wire:model="form.lifecycle.date_of_manufacture" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Entry Into Service (EIS)</x-enterprise.label>
                    <x-enterprise.input wire:model="form.lifecycle.entry_into_service" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Date of Acquisition</x-enterprise.label>
                    <x-enterprise.input wire:model="form.lifecycle.date_of_acquisition" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Acquisition Cost</x-enterprise.label>
                    <div class="grid grid-cols-[80px_1fr] gap-2">
                        <x-enterprise.input wire:model="form.lifecycle.currency" :variant="$isEdit ? null : 'disabled'" />
                        <x-enterprise.input wire:model="form.lifecycle.acquisition_cost" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Operator & Organization --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="user-circle" class="h-4 w-4 text-blue-600" />
                <span>2. Operator & Organization</span>
            </div>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <x-enterprise.label>Operator</x-enterprise.label>
                    <x-enterprise.input wire:model="form.operator_org.operator" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Owner / Lessor</x-enterprise.label>
                    <x-enterprise.input wire:model="form.operator_org.owner_lessor" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-enterprise.label>Maintenance Org. (MRO)</x-enterprise.label>
                        <x-enterprise.input wire:model="form.operator_org.mro" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div>
                        <x-enterprise.label>Home Base / Station</x-enterprise.label>
                        <x-enterprise.input wire:model="form.operator_org.home_base" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Mass & Limitations --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="archive-box" class="h-4 w-4 text-blue-600" />
                <span>3. Mass & Limitations</span>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-enterprise.label>MTOW</x-enterprise.label>
                    <div class="grid grid-cols-[1fr_56px] gap-2">
                        <x-enterprise.input wire:model="form.mass_limits.mtow" :variant="$isEdit ? null : 'disabled'" />
                        <x-enterprise.input wire:model="form.mass_limits.mtow_unit" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                </div>
                <div>
                    <x-enterprise.label>MLW</x-enterprise.label>
                    <div class="grid grid-cols-[1fr_56px] gap-2">
                        <x-enterprise.input wire:model="form.mass_limits.mlw" :variant="$isEdit ? null : 'disabled'" />
                        <x-enterprise.input wire:model="form.mass_limits.mlw_unit" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                </div>
                <div>
                    <x-enterprise.label>MZFW</x-enterprise.label>
                    <div class="grid grid-cols-[1fr_56px] gap-2">
                        <x-enterprise.input wire:model="form.mass_limits.mzfw" :variant="$isEdit ? null : 'disabled'" />
                        <x-enterprise.input wire:model="form.mass_limits.mzfw_unit" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                </div>
                <div>
                    <x-enterprise.label>OEW</x-enterprise.label>
                    <div class="grid grid-cols-[1fr_56px] gap-2">
                        <x-enterprise.input wire:model="form.mass_limits.oew" :variant="$isEdit ? null : 'disabled'" />
                        <x-enterprise.input wire:model="form.mass_limits.oew_unit" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Registration & Certification --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="document-text" class="h-4 w-4 text-blue-600" />
                <span>4. Registration & Certification</span>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-enterprise.label>Aircraft Registration</x-enterprise.label>
                    <x-enterprise.input wire:model="form.registration.aircraft_registration" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>State of Registry</x-enterprise.label>
                    <x-enterprise.input wire:model="form.registration.state_of_registry" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>CoA Issue Date</x-enterprise.label>
                    <x-enterprise.input wire:model="form.registration.coa_issue_date" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>CoA Expiry Date</x-enterprise.label>
                    <x-enterprise.input wire:model="form.registration.coa_expiry_date" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div class="col-span-2">
                    <x-enterprise.label>Airworthiness Authority</x-enterprise.label>
                    <x-enterprise.input wire:model="form.registration.airworthiness_authority" :variant="$isEdit ? null : 'disabled'" />
                </div>
            </div>
        </div>

        {{-- 5. Manufacturer Data --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="briefcase" class="h-4 w-4 text-blue-600" />
                <span>5. Manufacturer Data</span>
            </div>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <x-enterprise.label>Manufacturer</x-enterprise.label>
                    <x-enterprise.input wire:model="form.manufacturer.manufacturer" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Aircraft Model</x-enterprise.label>
                    <x-enterprise.input wire:model="form.manufacturer.aircraft_model" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-enterprise.label>MSN</x-enterprise.label>
                        <x-enterprise.input wire:model="form.manufacturer.manufacturer_serial_number" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div>
                        <x-enterprise.label>Line Number (LN)</x-enterprise.label>
                        <x-enterprise.input wire:model="form.manufacturer.line_number" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 6. Powerplant --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="cog-6-tooth" class="h-4 w-4 text-blue-600" />
                <span>6. Powerplant</span>
            </div>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <x-enterprise.label>Engine Type</x-enterprise.label>
                    <x-enterprise.input wire:model="form.powerplant.engine_type" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Engine Manufacturer</x-enterprise.label>
                    <x-enterprise.input wire:model="form.powerplant.engine_manufacturer" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-enterprise.label>Number of Engines</x-enterprise.label>
                        <x-enterprise.input wire:model="form.powerplant.number_of_engines" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div>
                        <x-enterprise.label>APU Installed</x-enterprise.label>
                        <div class="flex h-9 items-center">
                            <span class="inline-flex rounded-full {{ $g['powerplant']['apu_installed'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700' }} px-3 py-1 text-xs font-semibold">
                                {{ $g['powerplant']['apu_installed'] ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 7. Registered Owner Address --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4 lg:col-span-2">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="map-pin" class="h-4 w-4 text-blue-600" />
                <span>7. Registered Owner Address</span>
            </div>
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <div>
                    <x-enterprise.label>Address Line 1</x-enterprise.label>
                    <x-enterprise.input wire:model="form.owner_address.address_line_1" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Address Line 2</x-enterprise.label>
                    <x-enterprise.input wire:model="form.owner_address.address_line_2" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>City</x-enterprise.label>
                    <x-enterprise.input wire:model="form.owner_address.city" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>State / Province</x-enterprise.label>
                    <x-enterprise.input wire:model="form.owner_address.state_province" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Country</x-enterprise.label>
                    <x-enterprise.input wire:model="form.owner_address.country" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Postal Code</x-enterprise.label>
                    <x-enterprise.input wire:model="form.owner_address.postal_code" :variant="$isEdit ? null : 'disabled'" />
                </div>
            </div>
        </div>

        {{-- 8. Commercial Information --}}
        <div class="rounded-lg border border-gray-200 bg-white p-4 lg:col-span-3">
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-800">
                <x-icon name="briefcase" class="h-4 w-4 text-blue-600" />
                <span>8. Commercial Information (Optional)</span>
            </div>
            <div class="grid grid-cols-1 gap-3 md:grid-cols-5">
                <div>
                    <x-enterprise.label>Lease Type</x-enterprise.label>
                    <x-enterprise.input wire:model="form.commercial.lease_type" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Lessor Name</x-enterprise.label>
                    <x-enterprise.input wire:model="form.commercial.lessor_name" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Lease Start Date</x-enterprise.label>
                    <x-enterprise.input wire:model="form.commercial.lease_start_date" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Lease End Date</x-enterprise.label>
                    <x-enterprise.input wire:model="form.commercial.lease_end_date" :variant="$isEdit ? null : 'disabled'" />
                </div>
                <div>
                    <x-enterprise.label>Remarks</x-enterprise.label>
                    <x-enterprise.input wire:model="form.commercial.remarks" :variant="$isEdit ? null : 'disabled'" placeholder="Enter remarks (optional)" />
                </div>
            </div>
        </div>
    </div>

    @if ($isEdit)
        <div class="mt-5 flex items-center justify-end gap-2 border-t border-gray-100 pt-4">
            <button type="button" wire:click="cancelEdit"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" wire:click="save"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    @endif
</section>
