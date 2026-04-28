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

    <x-modal id="functional-location-filter-modal" title="Functional Location Filter" maxWidth="max-w-4xl">
        <div class="space-y-4">
            <div class="subtab-shell">
                <ul class="subtab-list flex-wrap gap-1.5">
                    @foreach ($filterTabs as $tab)
                        <li class="subtab-item">
                            <button
                                type="button"
                                class="subtab-link px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.12em]"
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
                <x-enterprise.panel class="space-y-4 p-4">
                    <div class="grid gap-4 xl:grid-cols-[minmax(0,1.15fr)_280px]">
                        <div class="space-y-3">
                            <x-enterprise.field-row label="Serial Number" for="fl_filter_serial_number" columns="sm:grid-cols-[128px_minmax(0,220px)]">
                                <x-enterprise.input id="fl_filter_serial_number" x-model="flSerialNumber" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Registration" for="fl_filter_registration" columns="sm:grid-cols-[128px_minmax(0,220px)]">
                                <x-enterprise.input id="fl_filter_registration" x-model="flRegistration" />
                            </x-enterprise.field-row>

                            <div class="space-y-1.5">
                                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Type</div>
                                <div class="overflow-hidden rounded-lg border border-gray-200">
                                    <table class="min-w-full border-collapse text-xs">
                                        <thead class="bg-gray-50/90">
                                            <tr>
                                                <th class="border-b border-gray-200 px-2.5 py-1.5 text-left font-semibold uppercase tracking-[0.14em] text-gray-500">#</th>
                                                <th class="border-b border-gray-200 px-2.5 py-1.5 text-left font-semibold uppercase tracking-[0.14em] text-gray-500">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($typePreviewRows as $rowNumber)
                                                <tr>
                                                    <td class="border-b border-gray-100 px-2.5 py-1.5 text-gray-400">{{ $rowNumber }}</td>
                                                    <td class="border-b border-gray-100 px-2.5 py-1.5 text-gray-400">{{ $rowNumber === 1 ? 'AW139' : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 bg-gray-50/70 px-3 py-2.5">
                                <x-enterprise.checkbox label="Maintenance Plan" x-model="flMaintenancePlan" />
                                <x-enterprise.input variant="lookup" placeholder="Search plan" x-bind:disabled="!flMaintenancePlan" />
                            </div>

                            <x-enterprise.control-row label="Status" for="fl_filter_status" columns="sm:grid-cols-[72px_minmax(0,1fr)]">
                                <x-enterprise.select id="fl_filter_status" x-model="flOperationalStatus">
                                    <option>Operational</option>
                                    <option>Grounded</option>
                                    <option>Under Review</option>
                                </x-enterprise.select>
                            </x-enterprise.control-row>

                            <div class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 bg-gray-50/70 px-3 py-2.5">
                                <x-enterprise.checkbox label="Load Types" x-model="flLoadTypes" />
                                <x-enterprise.input variant="lookup" placeholder="Select load type" x-bind:disabled="!flLoadTypes" />
                            </div>

                            <div class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 bg-gray-50/70 px-3 py-2.5">
                                <x-enterprise.checkbox label="Qualifications" x-model="flQualifications" />
                                <x-enterprise.input variant="lookup" placeholder="Select qualification" x-bind:disabled="!flQualifications" />
                            </div>

                            <div class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 bg-gray-50/70 px-3 py-2.5">
                                <x-enterprise.checkbox label="Positions" x-model="flPositions" />
                                <x-enterprise.input variant="lookup" placeholder="Select position" x-bind:disabled="!flPositions" />
                            </div>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeFilterTab === 'properties'" class="space-y-3">
                <x-enterprise.panel class="space-y-3.5 p-4">
                    <div class="grid gap-3.5 xl:grid-cols-2">
                        <div class="space-y-3">
                            <x-enterprise.field-row label="Mission Type" for="fl_filter_mission_type" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_mission_type" x-model="propertiesMissionType" variant="lookup" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Environment Type" for="fl_filter_environment_type" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_environment_type" x-model="propertiesEnvironmentType" variant="lookup" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Oil Type" for="fl_filter_oil_type" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_oil_type" x-model="propertiesOilType" />
                            </x-enterprise.field-row>
                        </div>

                        <div class="space-y-3">
                            <x-enterprise.field-row label="Date of Purchase" for="fl_filter_date_of_purchase" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_date_of_purchase" x-model="propertiesDateOfPurchase" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Purchase Price" for="fl_filter_purchase_price" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_purchase_price" x-model="propertiesPurchasePrice" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Cum. Flight Time" for="fl_filter_cum_flight_time" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_cum_flight_time" x-model="propertiesCumFlightTime" />
                            </x-enterprise.field-row>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-gray-50/70 px-3 py-2.5">
                        <x-enterprise.checkbox label="Only with anomaly on Data" x-model="propertiesOnlyAnomaly" />
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeFilterTab === 'part-information'" class="space-y-3">
                <x-enterprise.panel class="space-y-3.5 p-4">
                    <div class="grid gap-3.5 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]">
                        <div class="space-y-3">
                            <x-enterprise.field-row label="Serial Number" for="fl_filter_part_serial_number" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_part_serial_number" x-model="partSerialNumber" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Item No." for="fl_filter_item_no" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_item_no" x-model="partItemNo" variant="lookup" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Part Description" for="fl_filter_part_description" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_part_description" x-model="partDescription" />
                            </x-enterprise.field-row>
                        </div>

                        <div class="space-y-3">
                            <x-enterprise.field-row label="Engine Variant" for="fl_filter_engine_variant" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_engine_variant" x-model="partEngineVariant" variant="lookup" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Category Part" for="fl_filter_category_part" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_category_part" x-model="partCategoryPart" />
                            </x-enterprise.field-row>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeFilterTab === 'customers-information'" class="space-y-3">
                <x-enterprise.panel class="space-y-4 p-4">
                    <div class="grid gap-3.5 xl:grid-cols-2">
                        <div class="space-y-3 rounded-lg border border-gray-200 bg-gray-50/50 p-3">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-gray-500">Owner</div>
                            <x-enterprise.field-row label="Customer Owner Code" for="fl_filter_owner_code" columns="sm:grid-cols-[164px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_owner_code" x-model="customerOwnerCode" variant="lookup" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Customer Owner Name" for="fl_filter_owner_name" columns="sm:grid-cols-[164px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_owner_name" x-model="customerOwnerName" />
                            </x-enterprise.field-row>
                        </div>

                        <div class="space-y-3 rounded-lg border border-gray-200 bg-gray-50/50 p-3">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-gray-500">Operator</div>
                            <x-enterprise.field-row label="Customer Operator Code" for="fl_filter_operator_code" columns="sm:grid-cols-[164px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_operator_code" x-model="customerOperatorCode" variant="lookup" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Customer Operator Name" for="fl_filter_operator_name" columns="sm:grid-cols-[164px_minmax(0,1fr)]">
                                <x-enterprise.input id="fl_filter_operator_name" x-model="customerOperatorName" />
                            </x-enterprise.field-row>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeFilterTab === 'flight-ops'" class="space-y-3">
                <x-enterprise.panel class="space-y-4 p-4">
                    <div class="grid gap-3 xl:grid-cols-[170px_170px_170px]">
                        <x-enterprise.field-row label="MTOW Min" for="fl_filter_mtow_min" columns="grid-cols-[84px_minmax(0,1fr)]">
                            <x-enterprise.input id="fl_filter_mtow_min" x-model="flightOpsMtowMin" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="MTOW Max" for="fl_filter_mtow_max" columns="grid-cols-[84px_minmax(0,1fr)]">
                            <x-enterprise.input id="fl_filter_mtow_max" x-model="flightOpsMtowMax" />
                        </x-enterprise.field-row>
                        <x-enterprise.control-row label="Status" for="fl_filter_flight_ops_status" columns="grid-cols-[56px_minmax(0,1fr)]">
                            <x-enterprise.select id="fl_filter_flight_ops_status" x-model="flightOpsStatus">
                                <option value="">Any</option>
                                <option>Scheduled</option>
                                <option>Dispatched</option>
                                <option>Closed</option>
                            </x-enterprise.select>
                        </x-enterprise.control-row>
                    </div>

                    <x-enterprise.panel muted class="space-y-3 p-3.5">
                        <div class="text-sm font-semibold text-gray-900">Scheduled</div>
                        <div class="grid gap-3 xl:grid-cols-2">
                            <div class="space-y-2">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-gray-500">Departure Range</div>
                                <div class="grid gap-2.5 grid-cols-[minmax(0,1fr)_76px_minmax(0,1fr)_76px]">
                                    <x-enterprise.input x-model="departureFromDate" placeholder="Date" />
                                    <x-enterprise.input x-model="departureFromTime" placeholder="Time" />
                                    <x-enterprise.input x-model="departureToDate" placeholder="Date" />
                                    <x-enterprise.input x-model="departureToTime" placeholder="Time" />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-gray-500">Arrival Range</div>
                                <div class="grid gap-2.5 grid-cols-[minmax(0,1fr)_76px_minmax(0,1fr)_76px]">
                                    <x-enterprise.input x-model="arrivalFromDate" placeholder="Date" />
                                    <x-enterprise.input x-model="arrivalFromTime" placeholder="Time" />
                                    <x-enterprise.input x-model="arrivalToDate" placeholder="Date" />
                                    <x-enterprise.input x-model="arrivalToTime" placeholder="Time" />
                                </div>
                            </div>
                        </div>
                    </x-enterprise.panel>
                </x-enterprise.panel>
            </div>

        </div>

        <x-slot name="footer">
            <button type="button" class="btn-secondary" @click="resetFilterForm()">Reset</button>
            <button type="button" class="btn-secondary" @click="closeFilterModal()">Cancel</button>
            <button type="button" class="btn-primary" @click="applyFilterPreview()">Apply</button>
        </x-slot>
    </x-modal>
</div>
