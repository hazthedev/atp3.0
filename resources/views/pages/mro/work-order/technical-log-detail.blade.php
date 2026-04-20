@extends('layouts.app')

@section('title', 'Technical Log')

@php
    $logId = $logId ?? request()->route('log') ?? '00000034';

    $tabRows = [
        'defect' => [
            'employee' => 'WILLIAM ALFRED CC',
            'date' => '01.05.19',
            'time' => '17:00',
            'work_type' => '',
            'workload' => '',
            'wo_linked' => '',
            'description' => "DATE: 01.05.19\nA/F HRS: 1334:18\nAJL: 01287\nWO: WO-301586825\nWO3: WO-301586818,\nWO-301587292\nWP: KTH/WAY/704168\nWP3: KTH/WAY/704221\n\nM1) 100HRS INPS. DUE.\n\nM3) ROTATING CONTROLS INSP\nTO BE C/O O/R.",
            'show_deferral' => true,
        ],
        'corrective-actions' => [
            'employee' => 'WILLIAM ALFRED CC',
            'date' => '01.05.19',
            'time' => '17:00',
            'work_type' => 'Labor',
            'workload' => '1:30',
            'wo_linked' => '',
            'description' => "DATE: 01.05.19\nA/F HRS: 1334:18\nAJL: 01237\nWO: WO-301586825\nWO3: WO-301586818,\nWO-301587292\nWP: KTH/WAY/704168\nWP3: KTH/WAY/704221\n\nM1) C/OUT SATIS\nKTH/WAY/704168.\n\nM3) C/O SATIS KTH/WAY/704221.",
            'show_deferral' => false,
        ],
        'workaround' => [
            'employee' => '',
            'date' => '',
            'time' => '00:00',
            'work_type' => '',
            'workload' => '0:00',
            'wo_linked' => '',
            'description' => '',
            'show_deferral' => false,
        ],
    ];

    $attachmentRows = [
        ['path' => '', 'file' => '', 'date' => ''],
        ['path' => '', 'file' => '', 'date' => ''],
        ['path' => '', 'file' => '', 'date' => ''],
        ['path' => '', 'file' => '', 'date' => ''],
    ];
@endphp

@section('content')
    <div x-data="editMode(false)" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'defect',
            statusMessage: '',
            tabRows: @js($tabRows),
            logId: @js($logId),
            closePage() { this.statusMessage = `Technical log ${this.logId} closed from preview.`; },
        }"
    >
        <x-page-header
            title="Technical Log"
            description="Review the selected technical log, defect history, corrective actions, deferral data, attachments, and properties in the ATP MRO workspace."
        >
            <x-slot name="actions">
                <template x-if="!editing">
                    <button type="button" class="btn-primary" @click="enter()">Edit Record</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-primary" @click="toggle()">Save</button>
                </template>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1180px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_420px]">
                    <div class="space-y-3">
                        @foreach ([
                            'Log Number' => $logId,
                            'Functional Location' => '9M-WAY',
                            'Serial Number' => '31501',
                            'Registration' => '9M-WAY',
                            'Type' => 'AW139',
                        ] as $label => $value)
                            <x-enterprise.field-row :label="$label" :for="'mro_techlog_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[124px_minmax(0,1fr)]">
                                <div class="attach-inline-control">
                                    @if ($label === 'Functional Location' || $label === 'Type')
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                        </span>
                                    @endif
                                    <input id="{{ 'mro_techlog_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" value="{{ $value }}" class="input-field attach-input" />
                                </div>
                            </x-enterprise.field-row>
                        @endforeach
                    </div>

                    <div class="space-y-3">
                        @foreach ([
                            'Status' => 'Released',
                            'Flight' => '',
                            'Daily Flight Log' => '0000496',
                        ] as $label => $value)
                            <x-enterprise.field-row :label="$label" :for="'mro_techlog_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[104px_minmax(0,1fr)]">
                                <div class="attach-inline-control">
                                    @if ($label === 'Daily Flight Log')
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                        </span>
                                    @endif
                                    <input id="{{ 'mro_techlog_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" value="{{ $value }}" class="input-field attach-input" />
                                </div>
                            </x-enterprise.field-row>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Apply On" for="mro_techlog_apply_on" columns="sm:grid-cols-[108px_180px]">
                            <select id="mro_techlog_apply_on" class="input-field attach-input">
                                <option>Functional Location</option>
                                <option>Equipment</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.lookup-row label="Position" for="mro_techlog_position" columns="sm:grid-cols-[108px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="mro_techlog_position" type="text" value="Airframe" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>
                    </div>

                    <div class="space-y-3">
                        <div class="grid gap-3 sm:grid-cols-[148px_minmax(0,1fr)] sm:items-center">
                            <label class="attach-field-label">Chapter - Section - Subject - Sheet - Mark</label>
                            <div class="grid grid-cols-5 gap-2">
                                @foreach (['', '', '', '', ''] as $value)
                                    <input type="text" value="{{ $value }}" class="input-field attach-input" />
                                @endforeach
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-[148px_minmax(0,1fr)] sm:items-center">
                            <label class="attach-field-label">MEL Items</label>
                            <input type="text" class="input-field attach-input" />
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                    <div class="subtab-shell">
                        <ul class="subtab-list">
                            @foreach ([
                                'defect' => 'Defect',
                                'corrective-actions' => 'Corrective Actions',
                                'workaround' => 'Workaround',
                                'deferral' => 'Deferral',
                                'attachments' => 'Attachments',
                                'properties' => 'Properties',
                            ] as $key => $label)
                                <li class="subtab-item">
                                    <button type="button" class="subtab-link" :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = '{{ $key }}'">{{ $label }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                @foreach (['defect', 'corrective-actions', 'workaround'] as $tab)
                    <div x-cloak x-show="activeTab === '{{ $tab }}'" class="space-y-5">
                        <div class="grid gap-6 xl:grid-cols-[300px_minmax(0,1fr)]">
                            <div class="space-y-3">
                                <x-enterprise.lookup-row label="Employee" :for="'mro_techlog_'.$tab.'_employee'" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <div class="attach-inline-control">
                                        <input id="{{ 'mro_techlog_'.$tab.'_employee' }}" type="text" value="{{ $tabRows[$tab]['employee'] }}" class="input-field attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                </x-enterprise.lookup-row>
                                <x-enterprise.field-row label="Date" :for="'mro_techlog_'.$tab.'_date'" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="{{ 'mro_techlog_'.$tab.'_date' }}" type="text" value="{{ $tabRows[$tab]['date'] }}" class="input-field attach-input" /></x-enterprise.field-row>
                                <x-enterprise.field-row label="Time" :for="'mro_techlog_'.$tab.'_time'" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="{{ 'mro_techlog_'.$tab.'_time' }}" type="text" value="{{ $tabRows[$tab]['time'] }}" class="input-field attach-input" /></x-enterprise.field-row>
                                <x-enterprise.lookup-row label="Work Type" :for="'mro_techlog_'.$tab.'_work_type'" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <div class="attach-inline-control">
                                        <input id="{{ 'mro_techlog_'.$tab.'_work_type' }}" type="text" value="{{ $tabRows[$tab]['work_type'] }}" class="input-field attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                </x-enterprise.lookup-row>
                                <x-enterprise.field-row label="WorkLoad" :for="'mro_techlog_'.$tab.'_workload'" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="{{ 'mro_techlog_'.$tab.'_workload' }}" type="text" value="{{ $tabRows[$tab]['workload'] }}" class="input-field attach-input" /></x-enterprise.field-row>
                                <x-enterprise.field-row label="WO Linked" :for="'mro_techlog_'.$tab.'_wo_linked'" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="{{ 'mro_techlog_'.$tab.'_wo_linked' }}" type="text" value="{{ $tabRows[$tab]['wo_linked'] }}" class="input-field attach-input" /></x-enterprise.field-row>
                                <label class="attach-checkbox-inline" x-show="activeTab === 'defect'">
                                    <input type="checkbox" @if($tabRows[$tab]['show_deferral']) checked @endif />
                                    <span>Deferral</span>
                                </label>
                            </div>

                            <div class="space-y-3">
                                <div class="attach-field-label">Description</div>
                                <textarea class="input-field attach-textarea h-[250px]" readonly>{{ $tabRows[$tab]['description'] }}</textarea>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3 border-t border-gray-200 pt-4" x-show="activeTab === 'defect'">
                            <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Counter Reading</button>
                            <a href="{{ route('fleet.fleet-management-cockpit') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Fleet Mngt Cockpit</a>
                        </div>
                    </div>
                @endforeach

                <div x-cloak x-show="activeTab === 'deferral'" class="space-y-4 max-w-xl">
                    @foreach (['MEL Category', 'Dead Line', 'Authorization Number', 'Extension Number'] as $label)
                        <x-enterprise.lookup-row :label="$label" :for="'mro_techlog_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[148px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="{{ 'mro_techlog_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" class="input-field attach-input" />
                                @if ($label === 'MEL Category')
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                @endif
                            </div>
                        </x-enterprise.lookup-row>
                    @endforeach
                </div>

                <div x-cloak x-show="activeTab === 'attachments'" class="space-y-4">
                    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_120px]">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                            <x-slot name="thead"><tr><th>#</th><th>Path</th><th>File Name</th><th>Attachment Date</th></tr></x-slot>
                            <x-slot name="tbody">
                                @foreach ($attachmentRows as $index => $row)
                                    <tr><td>{{ $index + 1 }}</td><td>{{ $row['path'] }}</td><td>{{ $row['file'] }}</td><td>{{ $row['date'] }}</td></tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>

                        <div class="space-y-3">
                            <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Browse</button>
                            <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Display</button>
                            <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Delete</button>
                        </div>
                    </div>
                </div>

                <div x-cloak x-show="activeTab === 'properties'" class="space-y-4">
                    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_220px]">
                        <x-enterprise.field-row label="Techlog ID" for="mro_techlog_id" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="mro_techlog_id" type="text" :value="logId" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <div class="space-y-2">
                            <label class="attach-checkbox-inline"><input type="checkbox" /><span>Repetitive</span></label>
                            <label class="attach-checkbox-inline"><input type="checkbox" /><span>Failure Confirmed</span></label>
                        </div>
                    </div>
                </div>

                <x-enterprise.action-bar justify="start" class="border-t border-gray-200 pt-5">
                    <button type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">OK</button>
                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Cancel</button>
                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="closePage()">Close</button>
                </x-enterprise.action-bar>
            </x-enterprise.panel>
        </section>
    </div>
    </div>
@endsection
