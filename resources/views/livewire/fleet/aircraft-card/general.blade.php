@php
    $g = $data['general'];
    $isEdit = $editMode;
@endphp

<section class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm" data-edit-scope>
    <div class="mb-3 flex items-center justify-between">
        <h3 class="text-xs font-semibold text-gray-900">General Information</h3>
        @if (! $isEdit)
            <button type="button" wire:click="enableEdit"
                    class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                <x-icon name="pencil-square" class="h-3.5 w-3.5" /> Edit Record
            </button>
        @endif
    </div>

    <div class="overflow-x-auto">
        <div class="grid min-w-[1100px] grid-cols-3 gap-3">
            {{-- 1. Aircraft Lifecycle --}}
            <div class="rounded border border-gray-200 bg-white p-2.5">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="calendar-days" class="h-3.5 w-3.5 text-blue-600" />
                    <span>1. Aircraft Lifecycle</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
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
                        <div class="grid grid-cols-[64px_1fr] gap-1.5">
                            <x-enterprise.input wire:model="form.lifecycle.currency" :variant="$isEdit ? null : 'disabled'" />
                            <x-enterprise.input wire:model="form.lifecycle.acquisition_cost" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Operator & Organization --}}
            <div class="rounded border border-gray-200 bg-white p-2.5">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="user-circle" class="h-3.5 w-3.5 text-blue-600" />
                    <span>2. Operator & Organization</span>
                </div>
                <div class="space-y-2">
                    <div>
                        <x-enterprise.label>Operator</x-enterprise.label>
                        <x-enterprise.input wire:model="form.operator_org.operator" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div>
                        <x-enterprise.label>Owner / Lessor</x-enterprise.label>
                        <x-enterprise.input wire:model="form.operator_org.owner_lessor" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-enterprise.label>MRO</x-enterprise.label>
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
            <div class="rounded border border-gray-200 bg-white p-2.5">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="archive-box" class="h-3.5 w-3.5 text-blue-600" />
                    <span>3. Mass & Limitations</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <x-enterprise.label>MTOW</x-enterprise.label>
                        <div class="grid grid-cols-[1fr_48px] gap-1.5">
                            <x-enterprise.input wire:model="form.mass_limits.mtow" :variant="$isEdit ? null : 'disabled'" />
                            <x-enterprise.input wire:model="form.mass_limits.mtow_unit" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                    </div>
                    <div>
                        <x-enterprise.label>MLW</x-enterprise.label>
                        <div class="grid grid-cols-[1fr_48px] gap-1.5">
                            <x-enterprise.input wire:model="form.mass_limits.mlw" :variant="$isEdit ? null : 'disabled'" />
                            <x-enterprise.input wire:model="form.mass_limits.mlw_unit" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                    </div>
                    <div>
                        <x-enterprise.label>MZFW</x-enterprise.label>
                        <div class="grid grid-cols-[1fr_48px] gap-1.5">
                            <x-enterprise.input wire:model="form.mass_limits.mzfw" :variant="$isEdit ? null : 'disabled'" />
                            <x-enterprise.input wire:model="form.mass_limits.mzfw_unit" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                    </div>
                    <div>
                        <x-enterprise.label>OEW</x-enterprise.label>
                        <div class="grid grid-cols-[1fr_48px] gap-1.5">
                            <x-enterprise.input wire:model="form.mass_limits.oew" :variant="$isEdit ? null : 'disabled'" />
                            <x-enterprise.input wire:model="form.mass_limits.oew_unit" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. Registration & Certification --}}
            <div class="rounded border border-gray-200 bg-white p-2.5">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="document-text" class="h-3.5 w-3.5 text-blue-600" />
                    <span>4. Registration & Certification</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
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
            <div class="rounded border border-gray-200 bg-white p-2.5">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="briefcase" class="h-3.5 w-3.5 text-blue-600" />
                    <span>5. Manufacturer Data</span>
                </div>
                <div class="space-y-2">
                    <div>
                        <x-enterprise.label>Manufacturer</x-enterprise.label>
                        <x-enterprise.input wire:model="form.manufacturer.manufacturer" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div>
                        <x-enterprise.label>Aircraft Model</x-enterprise.label>
                        <x-enterprise.input wire:model="form.manufacturer.aircraft_model" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-enterprise.label>MSN</x-enterprise.label>
                            <x-enterprise.input wire:model="form.manufacturer.manufacturer_serial_number" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                        <div>
                            <x-enterprise.label>Line Number</x-enterprise.label>
                            <x-enterprise.input wire:model="form.manufacturer.line_number" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- 6. Powerplant --}}
            <div class="rounded border border-gray-200 bg-white p-2.5">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="cog-6-tooth" class="h-3.5 w-3.5 text-blue-600" />
                    <span>6. Powerplant</span>
                </div>
                <div class="space-y-2">
                    <div>
                        <x-enterprise.label>Engine Type</x-enterprise.label>
                        <x-enterprise.input wire:model="form.powerplant.engine_type" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div>
                        <x-enterprise.label>Engine Manufacturer</x-enterprise.label>
                        <x-enterprise.input wire:model="form.powerplant.engine_manufacturer" :variant="$isEdit ? null : 'disabled'" />
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-enterprise.label>Number of Engines</x-enterprise.label>
                            <x-enterprise.input wire:model="form.powerplant.number_of_engines" :variant="$isEdit ? null : 'disabled'" />
                        </div>
                        <div>
                            <x-enterprise.label>APU Installed</x-enterprise.label>
                            <div class="flex h-7 items-center">
                                <span class="inline-flex rounded-full {{ $g['powerplant']['apu_installed'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700' }} px-2 py-0.5 text-[10px] font-semibold">
                                    {{ $g['powerplant']['apu_installed'] ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 7. Registered Owner Address --}}
            <div class="rounded border border-gray-200 bg-white p-2.5 col-span-2">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="map-pin" class="h-3.5 w-3.5 text-blue-600" />
                    <span>7. Registered Owner Address</span>
                </div>
                <div class="grid grid-cols-3 gap-2">
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
            <div class="rounded border border-gray-200 bg-white p-2.5 col-span-3">
                <div class="mb-2 flex items-center gap-1.5 text-[11px] font-semibold text-gray-800">
                    <x-icon name="briefcase" class="h-3.5 w-3.5 text-blue-600" />
                    <span>8. Commercial Information (Optional)</span>
                </div>
                <div class="grid grid-cols-5 gap-2">
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
                        <x-enterprise.input wire:model="form.commercial.remarks" :variant="$isEdit ? null : 'disabled'" placeholder="Optional" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($isEdit)
        <div class="mt-3 flex items-center justify-end gap-2 border-t border-gray-100 pt-3">
            <button type="button" wire:click="cancelEdit"
                    class="rounded border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" wire:click="save"
                    class="rounded bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    @endif
</section>
