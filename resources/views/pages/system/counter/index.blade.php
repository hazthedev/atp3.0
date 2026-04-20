@extends('layouts.app')

@section('title', 'Counter')

@section('content')
    @php
        $measureUnits = \App\Models\MeasureUnit::orderBy('designation')->get();
        $counterRefs = \App\Models\CounterRef::orderBy('code')->get();
        $statuses = \App\Models\MroStatusObject::whereIn('name', ['Validate', 'No Valid'])
            ->orderBy('name')
            ->get();

        $counter = [
            'description' => 'Airframe Flight Hours',
            'status' => '00000006',
            'measure_unit' => '00000002',
            'order' => '10',
            'allow_change' => true,
            'value_mode' => '1',
            'min_value' => '0',
            'max_value' => '12000',
            'initial_value' => '0',
            'linked_measure' => 'Flight Cycles',
            'linked_measure_propagation' => false,
            'propagation' => false,
            'count_real_cycles_hours' => true,
            'warning_percent' => '90',
        ];
    @endphp

    <div
        class="space-y-6"
        x-data="{
            counter: @js($counter),
            statusMessage: '',
            findCounter() {
                this.statusMessage = `Counter preview ready for ${this.counter.description || 'selected definition'}.`;
            },
            cancelCounter() {
                this.statusMessage = 'Counter search cancelled for this preview.';
            },
        }"
    >
        <x-page-header
            title="Counter"
            description="Maintain counter thresholds, linked-propagation behavior, and measure validity limits using the same modern ATP form workspace."
        />

        <section class="attach-workspace-shell w-full space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_300px]">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Description" for="counter_description" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <input
                                id="counter_description"
                                type="text"
                                x-model="counter.description"
                                class="input-field attach-input"
                            />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Measure Unit" for="counter_measure_unit" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <div class="flex items-center gap-2">
                                <select id="counter_measure_unit" x-model="counter.measure_unit" class="input-field attach-input flex-1">
                                    @foreach ($measureUnits as $unit)
                                        <option value="{{ $unit->code }}">{{ $unit->code }} - {{ $unit->designation }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                        class="shrink-0 rounded-md p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                        title="Manage measure units"
                                        aria-label="Manage measure units"
                                        @click="$dispatch('open-measure-units')">
                                    <x-icon name="pencil-square" class="h-4 w-4" />
                                </button>
                            </div>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Allow Increase/decrease" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <x-enterprise.checkbox inline label="Enable manual adjustments" x-model="counter.allow_change" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Value ..." for="counter_value_mode" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <select id="counter_value_mode" x-model="counter.value_mode" class="input-field attach-input">
                                <option value="1">1 - Increase</option>
                                <option value="2">2 - Decrease</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Min Value" for="counter_min_value" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <input id="counter_min_value" type="text" x-model="counter.min_value" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Max Value" for="counter_max_value" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <input id="counter_max_value" type="text" x-model="counter.max_value" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Initial Value" for="counter_initial_value" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <input id="counter_initial_value" type="text" x-model="counter.initial_value" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Linked measure" for="counter_linked_measure" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_minmax(0,260px)] md:items-center">
                                <div class="flex items-center gap-2">
                                    <select id="counter_linked_measure" x-model="counter.linked_measure" class="input-field attach-input flex-1">
                                        <option value="">Select linked measure</option>
                                        @foreach ($counterRefs as $ref)
                                            <option value="{{ $ref->code }}">{{ $ref->code }} - {{ $ref->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button"
                                            class="shrink-0 rounded-md p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                            title="Manage MRO Counter Ref"
                                            aria-label="Manage MRO Counter Ref"
                                            @click="$dispatch('open-counter-refs')">
                                        <x-icon name="pencil-square" class="h-4 w-4" />
                                    </button>
                                </div>
                                <x-enterprise.checkbox inline label="Linked Measure Propagation" x-model="counter.linked_measure_propagation" />
                            </div>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Propagation" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <x-enterprise.checkbox inline label="Apply value propagation" x-model="counter.propagation" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Count real cycles & hours" class="grid-cols-[184px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <x-enterprise.checkbox inline label="Track real-time counter updates" x-model="counter.count_real_cycles_hours" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-4">
                        <x-enterprise.field-row label="Status" for="counter_status" class="grid-cols-[88px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <div class="flex items-center gap-2">
                                <select id="counter_status" x-model="counter.status" class="input-field attach-input flex-1">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->code }}">{{ $status->code }} - {{ $status->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                        class="shrink-0 rounded-md p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                        title="Manage MRO Status Object"
                                        aria-label="Manage MRO Status Object"
                                        @click="$dispatch('open-mro-status-objects')">
                                    <x-icon name="pencil-square" class="h-4 w-4" />
                                </button>
                            </div>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Order" for="counter_order" class="grid-cols-[88px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                            <input id="counter_order" type="text" x-model="counter.order" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <div class="rounded-xl border border-gray-200 bg-white p-4">
                            <div class="text-sm font-semibold text-gray-900">Counter Status Guide</div>
                            <div class="mt-3 space-y-2 text-sm text-slate-600">
                                <div class="flex items-center gap-2">
                                    <span class="h-3.5 w-3.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                                    <span>= Counter is valid</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-3.5 w-3.5 rounded-full bg-amber-500 ring-4 ring-amber-100"></span>
                                    <span>= Counter is near limit</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-3.5 w-3.5 rounded-full bg-rose-500 ring-4 ring-rose-100"></span>
                                    <span>= Counter exceeds max</span>
                                </div>
                            </div>
                            <x-enterprise.field-row label="Threshold" for="counter_warning_percent" class="mt-4 grid-cols-[96px_minmax(0,1fr)]" label-class="text-sm font-medium text-slate-700">
                                <div class="grid grid-cols-[88px_minmax(0,1fr)] items-center gap-2">
                                    <input id="counter_warning_percent" type="text" x-model="counter.warning_percent" class="input-field attach-input" />
                                    <span class="text-sm text-slate-600">% of max</span>
                                </div>
                            </x-enterprise.field-row>
                        </div>
                    </div>
                </div>
            </x-enterprise.panel>

            <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="findCounter()">Find</button>
                <button type="button" class="btn-secondary" @click="cancelCounter()">Cancel</button>
            </x-enterprise.action-bar>
        </section>

        @livewire('admin.measure-unit-manager')
        @livewire('admin.counter-ref-manager')
        @livewire('admin.mro-status-object-manager')
    </div>
@endsection

