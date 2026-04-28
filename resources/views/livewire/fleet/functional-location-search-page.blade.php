@php
    $filterTabs = [
        ['id' => 'functional-location', 'label' => 'Functional Location'],
        ['id' => 'properties', 'label' => 'Properties'],
        ['id' => 'part-information', 'label' => 'Part Information'],
        ['id' => 'customers-information', 'label' => 'Customers Information'],
        ['id' => 'flight-ops', 'label' => 'Flight OPS'],
    ];

    $typePreviewRows = range(1, 12);
@endphp

<div
    class="space-y-5"
    x-data="{
        filterStatusMessage: '',
        activeFilterTab: 'functional-location',
        flSerialNumber: '',
        flRegistration: '',
        flOperationalStatus: 'Operational',
        flMaintenancePlan: false,
        flLoadTypes: false,
        flQualifications: false,
        flPositions: false,
        propertiesMissionType: '',
        propertiesEnvironmentType: '',
        propertiesOilType: '',
        propertiesDateOfPurchase: '',
        propertiesPurchasePrice: '',
        propertiesCumFlightTime: '',
        propertiesOnlyAnomaly: false,
        partSerialNumber: '',
        partItemNo: '',
        partDescription: '',
        partEngineVariant: '',
        partCategoryPart: '',
        customerOwnerCode: '',
        customerOwnerName: '',
        customerOperatorCode: '',
        customerOperatorName: '',
        flightOpsMtowMin: '0.00',
        flightOpsMtowMax: '',
        flightOpsStatus: '',
        departureFromDate: '',
        departureFromTime: '',
        departureToDate: '',
        departureToTime: '',
        arrivalFromDate: '',
        arrivalFromTime: '',
        arrivalToDate: '',
        arrivalToTime: '',
        openFilterModal() {
            this.activeFilterTab = 'functional-location';
            window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'functional-location-filter-modal' } }));
        },
        closeFilterModal() {
            window.dispatchEvent(new CustomEvent('close-modal', { detail: { id: 'functional-location-filter-modal' } }));
        },
        resetFilterForm() {
            this.activeFilterTab = 'functional-location';
            this.flSerialNumber = '';
            this.flRegistration = '';
            this.flOperationalStatus = 'Operational';
            this.flMaintenancePlan = false;
            this.flLoadTypes = false;
            this.flQualifications = false;
            this.flPositions = false;
            this.propertiesMissionType = '';
            this.propertiesEnvironmentType = '';
            this.propertiesOilType = '';
            this.propertiesDateOfPurchase = '';
            this.propertiesPurchasePrice = '';
            this.propertiesCumFlightTime = '';
            this.propertiesOnlyAnomaly = false;
            this.partSerialNumber = '';
            this.partItemNo = '';
            this.partDescription = '';
            this.partEngineVariant = '';
            this.partCategoryPart = '';
            this.customerOwnerCode = '';
            this.customerOwnerName = '';
            this.customerOperatorCode = '';
            this.customerOperatorName = '';
            this.flightOpsMtowMin = '0.00';
            this.flightOpsMtowMax = '';
            this.flightOpsStatus = '';
            this.departureFromDate = '';
            this.departureFromTime = '';
            this.departureToDate = '';
            this.departureToTime = '';
            this.arrivalFromDate = '';
            this.arrivalFromTime = '';
            this.arrivalToDate = '';
            this.arrivalToTime = '';
        },
        applyFilterPreview() {
            this.filterStatusMessage = 'Functional location filter preset applied.';
            this.closeFilterModal();
        },
    }"
>
    <x-page-header
        title="Search Functional Locations"
        description="Search and browse registered functional locations before drilling into the selected aircraft record."
    >
        <x-slot name="actions">
            <button type="button" class="btn-secondary" @click="openFilterModal()">Filter</button>
        </x-slot>
    </x-page-header>

    <template x-if="filterStatusMessage">
        <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="filterStatusMessage"></div>
    </template>

    <p class="text-sm text-gray-500">
        Browse {{ $records->count() }} functional locations with client-side search, sorting, and pagination.
    </p>

    <x-data-table
        :empty="$records->count() === 0"
        empty-label="No functional locations found"
        empty-description="Try a different ID, registration, serial number, or operator."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">ID</th>
                <th class="table-th">Serial No.</th>
                <th class="table-th">Registration</th>
                <th class="table-th">Type</th>
                <th class="table-th">Operator name</th>
                <th class="table-th">Owner</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($records as $record)
                <tr class="table-row">
                    <td class="table-td"><x-enterprise.table-cell variant="arrow" :href="route('fleet.functional-location.show', ['id' => $record['id']])">{{ $record['code'] }}</x-enterprise.table-cell></td>
                    <td class="table-td">{{ $record['serial_no'] }}</td>
                    <td class="table-td">{{ $record['registration'] }}</td>
                    <td class="table-td">{{ $record['type'] }}</td>
                    <td class="table-td">{{ $record['operator_name'] }}</td>
                    <td class="table-td">{{ $record['owner_name'] }}</td>
                    <td class="table-td">
                        <div class="flex gap-2">
                            <a href="{{ route('fleet.functional-location.show', ['id' => $record['id']]) }}" class="btn-ghost px-3">View</a>
                            <a href="{{ route('fleet.functional-location.edit', ['id' => $record['id']]) }}" class="btn-secondary px-3">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>

    <x-modal id="functional-location-filter-modal" title="Functional Location Filter" maxWidth="max-w-5xl">
        <div class="space-y-4">
            <div class="subtab-shell">
                <ul class="subtab-list flex-wrap gap-1.5">
                    @foreach ($filterTabs as $tab)
                        <li class="subtab-item">
                            <button
                                type="button"
                                class="subtab-link px-3 py-1.5 text-[11px] font-semibold uppercase tracking-[0.14em]"
                                :class="activeFilterTab === '{{ $tab['id'] }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                @click="activeFilterTab = '{{ $tab['id'] }}'"
                            >
                                {{ $tab['label'] }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div x-cloak x-show="activeFilterTab === 'functional-location'" class="space-y-3">
                <div class="min-h-[540px] rounded-xl border border-gray-200 bg-white p-4">
                    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_260px]">
                        <div class="space-y-3">
                            <div class="grid gap-2 sm:grid-cols-[104px_minmax(0,220px)] sm:items-center">
                                <label for="fl_filter_serial_number" class="text-sm text-gray-700">Serial Number</label>
                                <x-enterprise.input id="fl_filter_serial_number" x-model="flSerialNumber" />
                            </div>
                            <div class="grid gap-2 sm:grid-cols-[104px_minmax(0,220px)] sm:items-center">
                                <label for="fl_filter_registration" class="text-sm text-gray-700">Registration</label>
                                <x-enterprise.input id="fl_filter_registration" x-model="flRegistration" />
                            </div>

                            <div class="space-y-2">
                                <div class="text-sm text-gray-700">Type</div>
                                <div class="overflow-hidden border border-gray-200">
                                    <table class="min-w-full border-collapse text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="w-14 border border-gray-200 px-3 py-1.5 text-left text-xs font-medium text-gray-600">#</th>
                                                <th class="border border-gray-200 px-3 py-1.5 text-left text-xs font-medium text-gray-600">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($typePreviewRows as $rowNumber)
                                                <tr>
                                                    <td class="border border-gray-200 px-3 py-2 text-gray-500">{{ $rowNumber }}</td>
                                                    <td class="border border-gray-200 px-3 py-2 text-gray-700">{{ $rowNumber === 1 ? 'AW139' : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 pt-1">
                            <div class="grid grid-cols-[18px_minmax(0,1fr)_44px] items-center gap-2">
                                <x-enterprise.checkbox x-model="flMaintenancePlan" />
                                <label class="text-sm text-gray-700">Maintenance Plan</label>
                                <button type="button" class="btn-secondary h-9 px-0 text-base font-semibold" x-bind:disabled="!flMaintenancePlan">...</button>
                            </div>

                            <div class="grid grid-cols-[18px_1fr] items-center gap-2">
                                <span class="h-4 w-4"></span>
                                <div class="space-y-1">
                                    <label for="fl_filter_status" class="text-sm text-gray-700">Status</label>
                                    <x-enterprise.select id="fl_filter_status" x-model="flOperationalStatus">
                                        <option>Operational</option>
                                        <option>Grounded</option>
                                        <option>Under Review</option>
                                    </x-enterprise.select>
                                </div>
                            </div>

                            <div class="grid grid-cols-[18px_minmax(0,1fr)_44px] items-center gap-2">
                                <x-enterprise.checkbox x-model="flLoadTypes" />
                                <label class="text-sm text-gray-700">Load Types</label>
                                <button type="button" class="btn-secondary h-9 px-0 text-base font-semibold" x-bind:disabled="!flLoadTypes">...</button>
                            </div>

                            <div class="grid grid-cols-[18px_minmax(0,1fr)_44px] items-center gap-2">
                                <x-enterprise.checkbox x-model="flQualifications" />
                                <label class="text-sm text-gray-700">Qualifications</label>
                                <button type="button" class="btn-secondary h-9 px-0 text-base font-semibold" x-bind:disabled="!flQualifications">...</button>
                            </div>

                            <div class="grid grid-cols-[18px_minmax(0,1fr)_44px] items-center gap-2">
                                <x-enterprise.checkbox x-model="flPositions" />
                                <label class="text-sm text-gray-700">Positions</label>
                                <button type="button" class="btn-secondary h-9 px-0 text-base font-semibold" x-bind:disabled="!flPositions">...</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeFilterTab === 'properties'" class="space-y-3">
                <div class="min-h-[540px] rounded-xl border border-gray-200 bg-white p-4">
                    <div class="grid gap-x-8 gap-y-2 xl:grid-cols-[1fr_1fr]">
                        <div class="space-y-2">
                            <div class="grid gap-2 sm:grid-cols-[118px_minmax(0,140px)_20px] sm:items-center">
                                <label for="fl_filter_mission_type" class="text-sm text-gray-700">Mission Type</label>
                                <x-enterprise.input id="fl_filter_mission_type" x-model="propertiesMissionType" />
                                <button type="button" class="h-5 w-5 rounded-full border border-gray-300 text-[10px] leading-none text-gray-500">...</button>
                            </div>
                            <div class="grid gap-2 sm:grid-cols-[118px_minmax(0,140px)_20px] sm:items-center">
                                <label for="fl_filter_environment_type" class="text-sm text-gray-700">Environment Type</label>
                                <x-enterprise.input id="fl_filter_environment_type" x-model="propertiesEnvironmentType" />
                                <button type="button" class="h-5 w-5 rounded-full border border-gray-300 text-[10px] leading-none text-gray-500">...</button>
                            </div>
                            <div class="grid gap-2 sm:grid-cols-[118px_minmax(0,140px)] sm:items-center">
                                <label for="fl_filter_oil_type" class="text-sm text-gray-700">Oil Type</label>
                                <x-enterprise.input id="fl_filter_oil_type" x-model="propertiesOilType" />
                            </div>
                            <div class="pt-1">
                                <x-enterprise.checkbox label="Only with anomaly on Data" x-model="propertiesOnlyAnomaly" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="grid gap-2 sm:grid-cols-[126px_minmax(0,160px)] sm:items-center">
                                <label for="fl_filter_date_of_purchase" class="text-sm text-gray-700">Date of Purchase</label>
                                <x-enterprise.input id="fl_filter_date_of_purchase" x-model="propertiesDateOfPurchase" />
                            </div>
                            <div class="grid gap-2 sm:grid-cols-[126px_minmax(0,160px)] sm:items-center">
                                <label for="fl_filter_purchase_price" class="text-sm text-gray-700">Purchase Price (in MY)</label>
                                <x-enterprise.input id="fl_filter_purchase_price" x-model="propertiesPurchasePrice" />
                            </div>
                            <div class="grid gap-2 sm:grid-cols-[126px_minmax(0,160px)] sm:items-center">
                                <label for="fl_filter_cum_flight_time" class="text-sm text-gray-700">Cum. Flight Time &gt; M</label>
                                <x-enterprise.input id="fl_filter_cum_flight_time" x-model="propertiesCumFlightTime" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeFilterTab === 'part-information'" class="space-y-3">
                <div class="min-h-[540px] rounded-xl border border-gray-200 bg-white p-4">
                    <div class="max-w-md space-y-2">
                        <div class="grid gap-2 sm:grid-cols-[100px_minmax(0,1fr)] sm:items-center">
                            <label for="fl_filter_part_serial_number" class="text-sm text-gray-700">Serial Number</label>
                            <x-enterprise.input id="fl_filter_part_serial_number" x-model="partSerialNumber" />
                        </div>
                        <div class="grid gap-2 sm:grid-cols-[100px_minmax(0,1fr)_20px] sm:items-center">
                            <label for="fl_filter_item_no" class="text-sm text-gray-700">Item No.</label>
                            <x-enterprise.input id="fl_filter_item_no" x-model="partItemNo" />
                            <button type="button" class="h-5 w-5 rounded-full border border-gray-300 text-[10px] leading-none text-gray-500">...</button>
                        </div>
                        <div class="grid gap-2 sm:grid-cols-[100px_minmax(0,1fr)] sm:items-center">
                            <label for="fl_filter_part_description" class="text-sm text-gray-700">Part Description</label>
                            <x-enterprise.input id="fl_filter_part_description" x-model="partDescription" />
                        </div>
                        <div class="grid gap-2 sm:grid-cols-[100px_minmax(0,1fr)_20px] sm:items-center">
                            <label for="fl_filter_engine_variant" class="text-sm text-gray-700">Engine Variant</label>
                            <x-enterprise.input id="fl_filter_engine_variant" x-model="partEngineVariant" />
                            <button type="button" class="h-5 w-5 rounded-full border border-gray-300 text-[10px] leading-none text-gray-500">...</button>
                        </div>
                        <div class="grid gap-2 sm:grid-cols-[100px_minmax(0,1fr)_20px] sm:items-center">
                            <label for="fl_filter_category_part" class="text-sm text-gray-700">Category Part</label>
                            <x-enterprise.input id="fl_filter_category_part" x-model="partCategoryPart" />
                            <button type="button" class="h-5 w-5 rounded-full border border-gray-300 text-[10px] leading-none text-gray-500">...</button>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeFilterTab === 'customers-information'" class="space-y-3">
                <div class="min-h-[540px] rounded-xl border border-gray-200 bg-white p-4">
                    <div class="max-w-xl space-y-10">
                        <div class="space-y-2">
                            <div class="grid gap-2 sm:grid-cols-[150px_minmax(0,1fr)_20px] sm:items-center">
                                <label for="fl_filter_owner_code" class="text-sm text-gray-700">Customer Owner Code</label>
                                <x-enterprise.input id="fl_filter_owner_code" x-model="customerOwnerCode" />
                                <button type="button" class="h-5 w-5 rounded-full border border-gray-300 text-[10px] leading-none text-gray-500">...</button>
                            </div>
                            <div class="grid gap-2 sm:grid-cols-[150px_minmax(0,1fr)] sm:items-center">
                                <label for="fl_filter_owner_name" class="text-sm text-gray-700">Customer Owner Name</label>
                                <x-enterprise.input id="fl_filter_owner_name" x-model="customerOwnerName" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="grid gap-2 sm:grid-cols-[150px_minmax(0,1fr)_20px] sm:items-center">
                                <label for="fl_filter_operator_code" class="text-sm text-gray-700">Customer Operator Code</label>
                                <x-enterprise.input id="fl_filter_operator_code" x-model="customerOperatorCode" />
                                <button type="button" class="h-5 w-5 rounded-full border border-gray-300 text-[10px] leading-none text-gray-500">...</button>
                            </div>
                            <div class="grid gap-2 sm:grid-cols-[150px_minmax(0,1fr)] sm:items-center">
                                <label for="fl_filter_operator_name" class="text-sm text-gray-700">Customer Operator Name</label>
                                <x-enterprise.input id="fl_filter_operator_name" x-model="customerOperatorName" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="activeFilterTab === 'flight-ops'" class="space-y-3">
                <div class="min-h-[540px] rounded-xl border border-gray-200 bg-white p-4">
                    <div class="max-w-3xl space-y-5">
                        <div class="grid gap-3 xl:grid-cols-[136px_1fr_92px_1fr_92px] xl:items-center">
                            <label for="fl_filter_mtow_min" class="text-sm text-gray-700">MTOW Min</label>
                            <x-enterprise.input id="fl_filter_mtow_min" x-model="flightOpsMtowMin" />
                            <label for="fl_filter_mtow_max" class="text-sm text-gray-700">MTOW Max</label>
                            <x-enterprise.input id="fl_filter_mtow_max" x-model="flightOpsMtowMax" />
                            <x-enterprise.select id="fl_filter_flight_ops_status" x-model="flightOpsStatus">
                                <option value="">Any</option>
                                <option>Scheduled</option>
                                <option>Dispatched</option>
                                <option>Closed</option>
                            </x-enterprise.select>
                        </div>

                        <div class="max-w-2xl border border-gray-300 p-3">
                            <div class="mb-3 text-sm text-gray-700">Scheduled</div>
                            <div class="space-y-4 text-sm text-gray-700">
                                <div class="grid gap-2 xl:grid-cols-[140px_1fr_72px_24px_1fr_72px] xl:items-center">
                                    <div>Departure Date From</div>
                                    <x-enterprise.input x-model="departureFromDate" />
                                    <x-enterprise.input x-model="departureFromTime" />
                                    <div class="text-center">To</div>
                                    <x-enterprise.input x-model="departureToDate" />
                                    <x-enterprise.input x-model="departureToTime" />
                                </div>

                                <div class="grid gap-2 xl:grid-cols-[140px_1fr_72px_24px_1fr_72px] xl:items-center">
                                    <div>Arrival Date From</div>
                                    <x-enterprise.input x-model="arrivalFromDate" />
                                    <x-enterprise.input x-model="arrivalFromTime" />
                                    <div class="text-center">To</div>
                                    <x-enterprise.input x-model="arrivalToDate" />
                                    <x-enterprise.input x-model="arrivalToTime" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <x-slot name="footer">
            <button type="button" class="btn-secondary" @click="resetFilterForm()">Reset</button>
            <button type="button" class="btn-secondary" @click="closeFilterModal()">Cancel</button>
            <button type="button" class="btn-primary" @click="applyFilterPreview()">Apply</button>
        </x-slot>
    </x-modal>
</div>
