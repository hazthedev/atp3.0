@extends('layouts.app')

@section('title', 'Fleet Synthesis')

@php
    // --- Dummy data (would come from services in production) ---

    // Counter freshness in days-since-last-update (0 = updated today)
    $aircraft = [
        ['type' => 'AW139', 'sn' => '31336', 'reg' => '9M-WAD', 'counter_age_days' => 2],
        ['type' => 'AW139', 'sn' => '31344', 'reg' => '9M-WAH', 'counter_age_days' => 0],
        ['type' => 'AW139', 'sn' => '41249', 'reg' => '9M-WBB', 'counter_age_days' => 5],
        ['type' => 'AW189', 'sn' => '49030', 'reg' => '9M-WSU', 'counter_age_days' => 1],
        ['type' => 'AW189', 'sn' => '49051', 'reg' => '9M-WSV', 'counter_age_days' => 3],
    ];

    $taskTypeCols = ['AD/SB', 'EOAS', 'OOP', 'Kardex', 'Others', 'Checks'];
    $includeTechLogs = true;

    $dashboardRows = [
        ['reg' => 'All', 'type' => null, 'sn' => null, 'synthesis' => true,
         'all'=>['red',5,371], 'AD/SB'=>['red',2,56], 'EOAS'=>['orange',4,34], 'OOP'=>['red',2,42],
         'Kardex'=>['orange',7,174], 'Others'=>['red',1,16], 'Checks'=>['orange',6,38], 'MEL/CFD'=>['red',1,11]],
        ['reg' => '9M-WAD', 'type' => 'AW139', 'sn' => '31336',
         'all'=>['red',4,69], 'AD/SB'=>['red',1,12], 'EOAS'=>['orange',2,8], 'OOP'=>['red',2,9],
         'Kardex'=>['green',30,30], 'Others'=>['red',1,4], 'Checks'=>['orange',1,6], 'MEL/CFD'=>[null,null,null]],
        ['reg' => '9M-WAH', 'type' => 'AW139', 'sn' => '31344',
         'all'=>['orange',6,71], 'AD/SB'=>['green',12,12], 'EOAS'=>['green',8,8], 'OOP'=>['orange',3,9],
         'Kardex'=>['orange',2,29], 'Others'=>['green',5,5], 'Checks'=>['orange',1,6], 'MEL/CFD'=>['green',2,2]],
        ['reg' => '9M-WBB', 'type' => 'AW139', 'sn' => '41249',
         'all'=>['red',1,81], 'AD/SB'=>['red',1,12], 'EOAS'=>['orange',1,9], 'OOP'=>['orange',2,13],
         'Kardex'=>['orange',4,35], 'Others'=>['orange',3,5], 'Checks'=>['orange',3,6], 'MEL/CFD'=>['green',1,1]],
        ['reg' => '9M-WSU', 'type' => 'AW189', 'sn' => '49030',
         'all'=>['green',76,76], 'AD/SB'=>['green',10,10], 'EOAS'=>['green',5,5], 'OOP'=>['green',5,5],
         'Kardex'=>['green',40,40], 'Others'=>['orange',2,2], 'Checks'=>['green',10,10], 'MEL/CFD'=>['green',4,4]],
        ['reg' => '9M-WSV', 'type' => 'AW189', 'sn' => '49051',
         'all'=>['orange',6,74], 'AD/SB'=>['orange',1,10], 'EOAS'=>['orange',1,4], 'OOP'=>['orange',1,6],
         'Kardex'=>['orange',1,40], 'Others'=>[null,null,null], 'Checks'=>['orange',1,10], 'MEL/CFD'=>['orange',1,4]],
    ];

    $detailsRows = [
        ['alarm'=>'red','reg'=>'9M-WAD','type'=>'OOP','reference'=>'AW139 CPI – ADDITIONAL 1','description'=>'Corrosion Prevention Inspection — Additional 1','pn'=>'','sn'=>'','category'=>'','interval'=>'12 M','last'=>"13.08.2020\n12695:51 Hrs\n19480 Cyc",'wo_number'=>'WO-23121','remaining_ac'=>'-1.33 Months','deadline_ac'=>'13.09.2020','due_date'=>'13.09.2020','work_package'=>'000008L2','wo'=>'WO-24247','date_in'=>'18.09.2020','notes'=>'1 MONTH'],
        ['alarm'=>'red','reg'=>'9M-WAD','type'=>'OOP','reference'=>'AW139 CPI- ADDITIONAL 2','description'=>'CPI Additional 2','pn'=>'','sn'=>'','category'=>'','interval'=>'12 M','last'=>"13.08.2020\n12695:51 Hrs\n19480 Cyc",'wo_number'=>'WO-23120','remaining_ac'=>'-1.33 Months','deadline_ac'=>'13.09.2020','due_date'=>'13.09.2020','work_package'=>'000008L2','wo'=>'WO-24246','date_in'=>'18.09.2020','notes'=>'1 MONTH'],
        ['alarm'=>'red','reg'=>'9M-WBB','type'=>'AD/SB','reference'=>'AW139 SB 139-594 PART II','description'=>'INSPECTION OF MAIN LANDING GEAR ACTUATOR BOLTS PART II','pn'=>'','sn'=>'','category'=>'','interval'=>'200:00 Hrs / 400 Cyc','last'=>'','wo_number'=>'','remaining_ac'=>"-27:21 Min\n223 Cyc",'deadline_ac'=>"1562:50 Hrs\n3704 Cyc",'due_date'=>'15.09.2020','work_package'=>'000008SX','wo'=>'','date_in'=>'','notes'=>''],
        ['alarm'=>'red','reg'=>'9M-WAD','type'=>'Others','reference'=>'EOAS AW139/EOAS/369','description'=>'AW139 Automatic Flight Control System Wiring Check','pn'=>'','sn'=>'','category'=>'','interval'=>'1 Year','last'=>'','wo_number'=>'','remaining_ac'=>'-0.1 Year','deadline_ac'=>'18.09.2020','due_date'=>'18.09.2020','work_package'=>'0000072M','wo'=>'WO-23292','date_in'=>'30.07.2020','notes'=>''],
        ['alarm'=>'red','reg'=>'9M-WAD','type'=>'AD/SB','reference'=>'AW139 SB SB139-642 Part I','description'=>'SB139-642 Part I - ATA 64 – TAIL ROTOR HEAD INSPECTION','pn'=>'','sn'=>'','category'=>'','interval'=>'50:00 Hrs / 3 M','last'=>'','wo_number'=>'','remaining_ac'=>"16:16 Hrs\n-0.27 Months",'deadline_ac'=>"12720:12 Hrs\n15.10.20",'due_date'=>'15.10.2020','work_package'=>'000007XI','wo'=>'WO-23210','date_in'=>'23.07.2020','notes'=>''],
        ['alarm'=>'orange','reg'=>'9M-WSV','type'=>'Checks','reference'=>'AW189 200FH','description'=>'AW189 200FH Inspection','pn'=>'','sn'=>'','category'=>'','interval'=>'200:00 Hrs','last'=>"06.05.2020\n1963:13 Hrs",'wo_number'=>'WO-20861','remaining_ac'=>'45:10 Hrs','deadline_ac'=>'2163:13 Hrs','due_date'=>'04.11.2020','work_package'=>'','wo'=>'','date_in'=>'','notes'=>'200:00 HRS'],
        ['alarm'=>'orange','reg'=>'9M-WSV','type'=>'EOAS','reference'=>'AW189 ENG 200HRS','description'=>'AW189 Engine 200-Hour Inspection','pn'=>'','sn'=>'','category'=>'','interval'=>'200:00 Hrs','last'=>"06.05.2020\n1963:13 Hrs",'wo_number'=>'WO-20862','remaining_ac'=>'45:10 Hrs','deadline_ac'=>'2163:13 Hrs','due_date'=>'04.11.2020','work_package'=>'','wo'=>'','date_in'=>'','notes'=>"200:00 HRS\nENG"],
        ['alarm'=>'green','reg'=>'9M-WAD','type'=>'Kardex','reference'=>'AW139 DUKANE T.M.','description'=>'underwater acoustic beacon','pn'=>'DK120','sn'=>'SD59337','category'=>'H/T LLP','interval'=>'6 Years','last'=>"20.06.2020\n12613:41 Hrs",'wo_number'=>'WO-21814','remaining_ac'=>'1.93 Months','deadline_ac'=>'20.12.2020','due_date'=>'20.12.2020','work_package'=>'000008LD','wo'=>'','date_in'=>'','notes'=>''],
    ];

    // Saved views preset for the mockup (would come from DB in production)
    $savedViews = [
        ['id' => 'v-default', 'name' => 'Morning standup', 'is_default' => true, 'filter' => ['status' => 'Applicable', 'remainingMonths' => 1, 'regs' => []]],
        ['id' => 'v-red',     'name' => 'Red alarms only', 'is_default' => false, 'filter' => ['status' => 'Applicable', 'alarmFilter' => 'red', 'regs' => []]],
        ['id' => 'v-aw139',   'name' => 'AW139 fleet',     'is_default' => false, 'filter' => ['status' => 'Applicable', 'regs' => ['9M-WAD','9M-WAH','9M-WBB']]],
    ];

    // Column catalogue for the Details grid. "key" must match the row array keys.
    $detailsColumns = [
        ['key' => 'alarm',         'label' => 'Alarm',          'default' => true,  'frozen' => true],
        ['key' => 'reg',           'label' => 'A/C Reg.',       'default' => true,  'frozen' => true],
        ['key' => 'type',          'label' => 'Type',           'default' => true,  'frozen' => true],
        ['key' => 'reference',     'label' => 'Reference',      'default' => true,  'frozen' => true],
        ['key' => 'description',   'label' => 'Description',    'default' => true],
        ['key' => 'pn',            'label' => 'PN',             'default' => true],
        ['key' => 'sn',            'label' => 'SN',             'default' => true],
        ['key' => 'category',      'label' => 'Category Part',  'default' => false],
        ['key' => 'interval',      'label' => 'Interval',       'default' => true],
        ['key' => 'last',          'label' => 'Last Action',    'default' => true],
        ['key' => 'wo_number',     'label' => 'Last WO',        'default' => false],
        ['key' => 'remaining_ac',  'label' => 'Remaining A/C',  'default' => true],
        ['key' => 'deadline_ac',   'label' => 'Deadline A/C',   'default' => true],
        ['key' => 'due_date',      'label' => 'Due Date',       'default' => true],
        ['key' => 'work_package',  'label' => 'Work Package',   'default' => true],
        ['key' => 'wo',            'label' => 'WO',             'default' => false],
        ['key' => 'date_in',       'label' => 'Date In',        'default' => false],
        ['key' => 'notes',         'label' => 'Notes',          'default' => false],
    ];

    // Initial view mode — set by thin wrappers at /dashboard and /details
    $initialView = $initialView ?? 'dashboard';
    $staleThresholdDays = 3;
@endphp

@section('content')
<div
    class="space-y-4"
    x-data="fleetSynthesisWorkspace({
        aircraft: @js($aircraft),
        taskTypeCols: @js($taskTypeCols),
        includeTechLogs: {{ $includeTechLogs ? 'true' : 'false' }},
        dashboardRows: @js($dashboardRows),
        detailsRows: @js($detailsRows),
        savedViews: @js($savedViews),
        detailsColumns: @js($detailsColumns),
        initialView: '{{ $initialView }}',
        staleThresholdDays: {{ $staleThresholdDays }},
    })"
>
    {{-- Page header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
        <div class="space-y-1">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-600">CAMO · Fleet Report</p>
            <h2 class="text-2xl font-bold text-gray-900">Fleet Synthesis</h2>
            <p class="max-w-3xl text-sm text-gray-500">Unified workspace — filter on the left, switch between colored Dashboard and Details grid on the right.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn-secondary" @click="refresh()" :disabled="refreshing">
                <svg x-show="refreshing" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity=".25"/><path d="M4 12a8 8 0 018-8"/></svg>
                <x-icon name="arrow-path" x-show="!refreshing" class="h-4 w-4" /> Refresh
            </button>
            <div class="relative" @click.outside="openReport = false">
                <button class="btn-primary" @click="openReport = !openReport">
                    <x-icon name="document-arrow-down" class="h-4 w-4" /> Report
                </button>
                <div x-cloak x-show="openReport" x-transition class="absolute right-0 z-30 mt-2 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl">
                    <div class="flex items-center justify-between gap-3 px-4 py-2.5 text-sm">
                        <span class="text-gray-700">Fleet Synthesis – Details</span>
                        <span class="text-xs text-gray-400">XLS</span>
                        <button class="btn-secondary !py-1 !text-xs" @click="alert('Generate XLS — mockup')">Generate</button>
                    </div>
                    <div class="flex items-center justify-between gap-3 border-t border-gray-100 px-4 py-2.5 text-sm">
                        <span class="text-gray-700">Maintenance Forecast</span>
                        <span class="text-xs text-gray-400">PDF</span>
                        <button class="btn-secondary !py-1 !text-xs" @click="alert('Generate PDF — mockup')">Generate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STICKY CONTEXT BAR (improvement #3) --}}
    <section class="sticky top-0 z-20 overflow-hidden rounded-xl border border-gray-200 bg-white/95 shadow-sm backdrop-blur">
        <div class="flex flex-wrap items-center gap-3 px-4 py-2.5">
            {{-- Current filter chips --}}
            <div class="flex flex-wrap items-center gap-1.5 text-xs">
                <span class="font-semibold uppercase tracking-wider text-gray-400">Scope</span>
                <template x-if="selectedAc.length === 0">
                    <span class="rounded-full bg-gray-100 px-2.5 py-0.5 font-medium text-gray-700">All A/C</span>
                </template>
                <template x-for="reg in selectedAc" :key="reg">
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 font-medium text-blue-700">
                        <span x-text="reg"></span>
                        <button class="text-blue-400 hover:text-blue-700" @click="toggleAc(reg)">&times;</button>
                    </span>
                </template>
                <span class="rounded-full bg-gray-100 px-2.5 py-0.5 font-medium text-gray-700" x-text="status"></span>
                <template x-if="remainingHours">
                    <span class="rounded-full bg-gray-100 px-2.5 py-0.5 font-medium text-gray-700" x-text="'≤ ' + remainingHours + 'h'"></span>
                </template>
                <template x-if="remainingCycles">
                    <span class="rounded-full bg-gray-100 px-2.5 py-0.5 font-medium text-gray-700" x-text="'≤ ' + remainingCycles + 'c'"></span>
                </template>
                <template x-if="remainingMonths">
                    <span class="rounded-full bg-gray-100 px-2.5 py-0.5 font-medium text-gray-700" x-text="'≤ ' + remainingMonths + 'm'"></span>
                </template>
            </div>

            {{-- Alarm summary with colorblind-safe icons (improvement #5) --}}
            <div class="ml-auto flex items-center gap-2 text-sm">
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1 font-semibold text-red-700" title="Overdue">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zM7.28 6.22a.75.75 0 011.06 0L10 7.94l1.66-1.72a.75.75 0 111.08 1.04L11.04 9l1.7 1.74a.75.75 0 11-1.08 1.04L10 10.06l-1.66 1.72a.75.75 0 11-1.08-1.04L8.96 9l-1.68-1.74a.75.75 0 010-1.04z"/></svg>
                    <span x-text="alarmCounts.red"></span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1 font-semibold text-amber-700" title="Within alarm window">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2l8.5 14.5h-17L10 2zm0 5v5m0 2v.01"/></svg>
                    <span x-text="alarmCounts.orange"></span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 font-semibold text-emerald-700" title="Healthy">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.85-10.35a.75.75 0 00-1.2-.9l-3.65 4.87-1.85-1.85a.75.75 0 10-1.06 1.06l2.5 2.5a.75.75 0 001.13-.08l4.13-5.5z" clip-rule="evenodd"/></svg>
                    <span x-text="alarmCounts.green"></span>
                </span>
            </div>

            {{-- Stalest counter warning (improvement #4) --}}
            <template x-if="stalestAc">
                <div class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-800">
                    <x-icon name="clock" class="h-3.5 w-3.5" />
                    Stalest counter: <span class="font-bold" x-text="stalestAc.reg"></span>
                    <span x-text="'(' + stalestAc.counter_age_days + ' d)'"></span>
                </div>
            </template>

            {{-- View toggle (improvement #1) --}}
            <div class="flex items-center overflow-hidden rounded-lg border border-gray-300 text-sm">
                <button class="px-3 py-1.5 transition" :class="view==='dashboard' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100'" @click="view='dashboard'">Dashboard</button>
                <button class="border-x border-gray-300 px-3 py-1.5 transition" :class="view==='details' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100'" @click="view='details'">Details</button>
                <button class="px-3 py-1.5 transition" :class="view==='both' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100'" @click="view='both'">Both</button>
            </div>
        </div>
    </section>

    {{-- Main grid: filter rail + content --}}
    <div class="grid gap-4" :class="filterOpen ? 'lg:grid-cols-[320px_1fr]' : 'lg:grid-cols-[56px_1fr]'">

        {{-- LEFT RAIL: collapsible filter + saved views (improvement #1 & #2) --}}
        <aside class="rounded-2xl border border-gray-200 bg-white shadow-sm" :class="filterOpen ? 'p-5' : 'p-2'">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900" x-show="filterOpen">Filters</h3>
                <button class="rounded-lg p-1.5 text-gray-500 hover:bg-gray-100" @click="filterOpen = !filterOpen" :title="filterOpen ? 'Collapse' : 'Expand filters'">
                    <x-icon name="sliders-h" class="h-5 w-5" />
                </button>
            </div>

            <div x-show="filterOpen" x-transition class="mt-4 space-y-5">

                {{-- Saved Views (improvement #2) --}}
                <div>
                    <div class="mb-1.5 flex items-center justify-between">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Saved view</label>
                        <button class="text-xs font-medium text-blue-600 hover:underline" @click="openManageViews = true">Manage</button>
                    </div>
                    <select class="input-field" x-model="activeViewId" @change="applyView(activeViewId)">
                        <option value="">— custom —</option>
                        <template x-for="v in savedViews" :key="v.id">
                            <option :value="v.id" x-text="v.name + (v.is_default ? ' (default)' : '')"></option>
                        </template>
                    </select>
                    <div class="mt-2 flex gap-2">
                        <button class="btn-ghost !py-1 !text-xs flex-1" @click="openSaveView = true">
                            <x-icon name="star" class="h-3.5 w-3.5" /> Save current
                        </button>
                    </div>
                </div>

                {{-- A/C multiselect with counter-freshness badges (improvement #4) --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">A/C Registration</label>
                    <div class="max-h-56 overflow-y-auto rounded-lg border border-gray-200">
                        <template x-for="ac in aircraft" :key="ac.reg">
                            <label class="flex cursor-pointer items-center gap-2 border-b border-gray-100 px-3 py-2 text-sm last:border-0 hover:bg-gray-50">
                                <input type="checkbox" :checked="selectedAc.includes(ac.reg)" @change="toggleAc(ac.reg)" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span class="font-medium text-gray-700" x-text="ac.reg"></span>
                                <span class="text-xs text-gray-400" x-text="ac.type"></span>
                                <span class="ml-auto inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 text-[10px] font-medium"
                                      :class="ac.counter_age_days > staleThresholdDays ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-500'"
                                      :title="'Counter updated ' + ac.counter_age_days + ' day(s) ago'">
                                    <span x-text="ac.counter_age_days + 'd'"></span>
                                </span>
                            </label>
                        </template>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Status</label>
                    <select class="input-field" x-model="status"><option>Applied</option><option>Applicable</option><option>Non Applicable</option></select>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-gray-500">Hours</label>
                        <input type="number" class="input-field !py-2 !text-sm" placeholder="30" x-model="remainingHours" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-gray-500">Cycles</label>
                        <input type="number" class="input-field !py-2 !text-sm" placeholder="30" x-model="remainingCycles" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-gray-500">Months</label>
                        <input type="number" class="input-field !py-2 !text-sm" placeholder="1" x-model="remainingMonths" />
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <button class="btn-ghost flex-1" @click="resetFilters()">Reset</button>
                </div>
            </div>
        </aside>

        {{-- MAIN PANE --}}
        <main class="space-y-4">

            {{-- DASHBOARD (improvement #5: colorblind-safe alarm tiles with glyphs) --}}
            <section x-show="view === 'dashboard' || view === 'both'" class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <header class="flex items-center justify-between border-b border-gray-100 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">Dashboard</h3>
                    <span class="text-xs text-gray-400">Click any tile to drill into Details</span>
                </header>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0 text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500">
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">A/C Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">SN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Reg.</th>
                                <th class="border-l border-gray-200 px-2 py-3 text-center text-xs font-semibold uppercase tracking-wider" colspan="2">All</th>
                                @foreach ($taskTypeCols as $col)
                                    <th class="border-l border-gray-200 px-2 py-3 text-center text-xs font-semibold uppercase tracking-wider" colspan="2">{{ $col }}</th>
                                @endforeach
                                @if ($includeTechLogs)
                                    <th class="border-l border-gray-200 px-2 py-3 text-center text-xs font-semibold uppercase tracking-wider" colspan="2">MEL/CFD</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="row in filteredDashboardRows" :key="row.reg">
                                <tr :class="row.synthesis ? 'bg-slate-50 font-semibold' : 'hover:bg-blue-50/40'" class="border-b border-gray-100">
                                    <td class="px-4 py-3" x-text="row.type ?? ''"></td>
                                    <td class="px-4 py-3 text-gray-500" x-text="row.sn ?? ''"></td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1.5">
                                            <span x-text="row.reg" class="font-medium" :class="row.synthesis ? 'text-slate-700' : 'text-blue-600'"></span>
                                            {{-- Counter freshness badge (improvement #4) --}}
                                            <template x-if="!row.synthesis && counterFreshness(row.reg) !== null">
                                                <span class="inline-flex items-center gap-0.5 rounded px-1 py-0.5 text-[9px] font-semibold uppercase tracking-wider"
                                                      :class="counterFreshness(row.reg) > staleThresholdDays ? 'bg-amber-100 text-amber-700' : 'bg-emerald-50 text-emerald-600'"
                                                      :title="'Counter updated ' + counterFreshness(row.reg) + ' day(s) ago'">
                                                    <span x-text="counterFreshness(row.reg) + 'd'"></span>
                                                </span>
                                            </template>
                                        </div>
                                    </td>

                                    <template x-for="col in dashboardColKeys" :key="col">
                                        <template x-if="row[col]">
                                            {{-- Qty tile + Total cell --}}
                                            <td class="px-2 py-3 text-center" :class="col === 'all' ? 'border-l border-gray-200' : (col === 'AD/SB' || col === 'MEL/CFD' ? 'border-l border-gray-200' : '')">
                                                <div class="flex flex-col items-center gap-0.5">
                                                    <template x-if="row[col][0]">
                                                        <button
                                                            class="inline-flex h-8 w-11 items-center justify-center gap-1 rounded-md text-sm font-bold shadow-sm transition hover:scale-105"
                                                            :class="alarmClasses[row[col][0]]"
                                                            @click="drillIntoDetails(row.reg, col, row[col][0])"
                                                        >
                                                            <template x-if="row[col][0] === 'red'">
                                                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M7.28 6.22a.75.75 0 011.06 0L10 7.94l1.66-1.72a.75.75 0 111.08 1.04L11.04 9l1.7 1.74a.75.75 0 11-1.08 1.04L10 10.06l-1.66 1.72a.75.75 0 11-1.08-1.04L8.96 9l-1.68-1.74a.75.75 0 010-1.04z"/></svg>
                                                            </template>
                                                            <template x-if="row[col][0] === 'orange'">
                                                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.515 2.625H3.72c-1.345 0-2.188-1.458-1.515-2.625zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                                            </template>
                                                            <template x-if="row[col][0] === 'green'">
                                                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                                                            </template>
                                                            <span x-text="row[col][1]"></span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </td>
                                        </template>
                                        <template x-if="!row[col]">
                                            <td class="px-2 py-3" :class="col === 'all' ? 'border-l border-gray-200' : (col === 'AD/SB' || col === 'MEL/CFD' ? 'border-l border-gray-200' : '')"></td>
                                        </template>
                                        <td class="px-2 py-3 text-center text-xs text-slate-500">
                                            <template x-if="row[col] && row[col][2] !== null">
                                                <button class="hover:text-blue-600 hover:underline" @click="drillIntoDetails(row.reg, col, null)" x-text="row[col][2]"></button>
                                            </template>
                                        </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <footer class="flex flex-wrap items-center gap-4 border-t border-gray-100 px-5 py-2 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="inline-flex h-4 w-4 items-center justify-center rounded bg-red-600 text-white"><svg class="h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor"><path d="M7.28 6.22a.75.75 0 011.06 0L10 7.94l1.66-1.72a.75.75 0 111.08 1.04L11.04 9l1.7 1.74a.75.75 0 11-1.08 1.04L10 10.06l-1.66 1.72a.75.75 0 11-1.08-1.04L8.96 9l-1.68-1.74a.75.75 0 010-1.04z"/></svg></span>
                        Overdue
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="inline-flex h-4 w-4 items-center justify-center rounded bg-amber-500 text-white"><svg class="h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.515 2.625H3.72c-1.345 0-2.188-1.458-1.515-2.625z" clip-rule="evenodd"/></svg></span>
                        Alarm window
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="inline-flex h-4 w-4 items-center justify-center rounded bg-emerald-500 text-white"><svg class="h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg></span>
                        Healthy
                    </span>
                </footer>
            </section>

            {{-- DETAILS --}}
            <section x-show="view === 'details' || view === 'both'" class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <header class="flex flex-col gap-3 border-b border-gray-100 px-5 py-3 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-semibold text-gray-900">Details</h3>
                        <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700" x-text="filteredDetailsRows.length + ' rows'"></span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <div class="relative flex-1 min-w-[200px]">
                            <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                            <input type="text" class="input-field pl-9 !py-2 !text-sm" placeholder="Search…" x-model="search" />
                        </div>
                        {{-- Column chooser (improvement #3) --}}
                        <div class="relative" @click.outside="openColumns = false">
                            <button class="btn-ghost !py-2" @click="openColumns = !openColumns" title="Column chooser">
                                <x-icon name="squares-2x2" class="h-4 w-4" /> Columns
                            </button>
                            <div x-cloak x-show="openColumns" x-transition class="absolute right-0 z-30 mt-2 w-72 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl">
                                <div class="border-b border-gray-100 px-3 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Visible columns</div>
                                <div class="max-h-80 overflow-y-auto p-2">
                                    <template x-for="col in detailsColumns" :key="col.key">
                                        <label class="flex cursor-pointer items-center gap-2 rounded px-2 py-1.5 text-sm hover:bg-gray-50">
                                            <input type="checkbox" :checked="visibleColumns.includes(col.key)" @change="toggleColumn(col.key)" :disabled="col.frozen" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                            <span :class="col.frozen ? 'text-gray-400' : 'text-gray-700'" x-text="col.label"></span>
                                            <template x-if="col.frozen">
                                                <span class="ml-auto rounded bg-gray-100 px-1.5 py-0.5 text-[9px] font-semibold uppercase text-gray-500">locked</span>
                                            </template>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Selection toolbar --}}
                <template x-if="selectedCount > 0">
                    <div class="flex flex-wrap items-center gap-2 border-b border-gray-100 bg-blue-50/50 px-5 py-2 text-sm">
                        <span class="font-semibold text-blue-700" x-text="selectedCount + ' selected'"></span>
                        <div class="mx-2 h-4 w-px bg-blue-200"></div>
                        <button class="btn-ghost !py-1 !text-xs" x-show="selectedCount === 1" @click="alert('Maintenance Plan — mockup')">Maintenance Plan</button>
                        <button class="btn-ghost !py-1 !text-xs" x-show="selectedCount === 1" @click="alert('Update Task — mockup')">Update Task</button>
                        <button class="btn-ghost !py-1 !text-xs" x-show="selectedCount === 1" @click="alert('Application History — mockup')">App History</button>
                        <button class="btn-secondary !py-1 !text-xs" @click="alert('Create WP — mockup')">Create WP</button>
                        <button class="btn-secondary !py-1 !text-xs" @click="alert('Include into WP — mockup')">Include into WP</button>
                        <button class="ml-auto text-xs text-gray-500 hover:text-gray-700" @click="clearSelection()">Clear</button>
                    </div>
                </template>

                <div class="overflow-x-auto">
                    <table class="min-w-max border-separate border-spacing-0 text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500">
                                <th class="sticky left-0 z-10 w-10 bg-slate-50 px-3 py-3"></th>
                                <template x-for="col in activeColumns" :key="col.key">
                                    <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider" x-text="col.label"></th>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, i) in filteredDetailsRows" :key="i">
                                <tr class="border-b border-gray-100 hover:bg-blue-50/40" :class="selected[i] && 'bg-blue-50'">
                                    <td class="sticky left-0 z-10 bg-white px-3 py-3">
                                        <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500" x-model="selected[i]" @change="recount()" />
                                    </td>
                                    <template x-for="col in activeColumns" :key="col.key">
                                        <td class="px-3 py-3 whitespace-pre-line" :class="col.key === 'remaining_ac' && row[col.key]?.toString().startsWith('-') ? 'text-red-600 font-medium' : 'text-gray-700'">
                                            {{-- Alarm cell with glyph (improvement #5) --}}
                                            <template x-if="col.key === 'alarm'">
                                                <span class="inline-flex h-6 w-9 items-center justify-center rounded text-white shadow-sm"
                                                      :class="alarmClasses[row.alarm]">
                                                    <template x-if="row.alarm === 'red'">
                                                        <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M7.28 6.22a.75.75 0 011.06 0L10 7.94l1.66-1.72a.75.75 0 111.08 1.04L11.04 9l1.7 1.74a.75.75 0 11-1.08 1.04L10 10.06l-1.66 1.72a.75.75 0 11-1.08-1.04L8.96 9l-1.68-1.74a.75.75 0 010-1.04z"/></svg>
                                                    </template>
                                                    <template x-if="row.alarm === 'orange'">
                                                        <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.515 2.625H3.72c-1.345 0-2.188-1.458-1.515-2.625z" clip-rule="evenodd"/></svg>
                                                    </template>
                                                    <template x-if="row.alarm === 'green'">
                                                        <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                                                    </template>
                                                </span>
                                            </template>
                                            <template x-if="col.key === 'reg'">
                                                <div class="flex items-center gap-1.5">
                                                    <a href="#" class="font-medium text-blue-600 hover:underline" x-text="row.reg"></a>
                                                    <template x-if="counterFreshness(row.reg) > staleThresholdDays">
                                                        <span class="rounded bg-amber-100 px-1 py-0.5 text-[9px] font-semibold text-amber-700" :title="'Counter updated ' + counterFreshness(row.reg) + ' day(s) ago'" x-text="counterFreshness(row.reg) + 'd'"></span>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="col.key === 'pn' && row.pn">
                                                <a href="#" class="text-blue-600 hover:underline" x-text="row.pn"></a>
                                            </template>
                                            <template x-if="col.key === 'sn' && row.sn">
                                                <a href="#" class="text-blue-600 hover:underline" x-text="row.sn"></a>
                                            </template>
                                            <template x-if="col.key === 'work_package' && row.work_package">
                                                <a href="#" class="text-blue-600 hover:underline" x-text="row.work_package"></a>
                                            </template>
                                            <template x-if="col.key === 'wo' && row.wo">
                                                <a href="#" class="text-blue-600 hover:underline" x-text="row.wo"></a>
                                            </template>
                                            <template x-if="!['alarm','reg','pn','sn','work_package','wo'].includes(col.key)">
                                                <span class="text-xs leading-tight" x-text="row[col.key]"></span>
                                            </template>
                                        </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    {{-- Save View modal (improvement #2) --}}
    <div x-cloak x-show="openSaveView" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 px-4" @click.self="openSaveView = false">
        <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
            <h4 class="mb-4 text-lg font-semibold text-gray-900">Save current view</h4>
            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Name</label>
            <input type="text" class="input-field" placeholder="e.g. Monday overdue check" x-model="newViewName" />
            <label class="mt-3 flex items-center gap-2 text-sm">
                <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500" x-model="newViewIsDefault" />
                Set as default
            </label>
            <p class="mt-3 text-xs text-gray-500">Saves: filters · selected columns · view mode · sort order.</p>
            <div class="mt-5 flex justify-end gap-2">
                <button class="btn-ghost" @click="openSaveView = false">Cancel</button>
                <button class="btn-primary" @click="saveCurrentView()" :disabled="!newViewName">Save</button>
            </div>
        </div>
    </div>

    {{-- Manage Views modal --}}
    <div x-cloak x-show="openManageViews" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 px-4" @click.self="openManageViews = false">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <h4 class="mb-4 text-lg font-semibold text-gray-900">Manage saved views</h4>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wider text-gray-500">
                        <th class="py-2">Name</th>
                        <th class="py-2 text-center">Default</th>
                        <th class="py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="v in savedViews" :key="v.id">
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 font-medium" x-text="v.name"></td>
                            <td class="py-2.5 text-center">
                                <input type="radio" name="defaultView" :checked="v.is_default" @change="setDefaultView(v.id)" class="text-blue-600 focus:ring-blue-500" />
                            </td>
                            <td class="py-2.5 text-right text-xs">
                                <button class="text-gray-500 hover:text-red-600" @click="deleteView(v.id)">Delete</button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="savedViews.length === 0">
                        <tr><td colspan="3" class="py-4 text-center text-sm text-gray-400">No saved views yet.</td></tr>
                    </template>
                </tbody>
            </table>
            <div class="mt-5 flex justify-end">
                <button class="btn-primary" @click="openManageViews = false">Done</button>
            </div>
        </div>
    </div>
</div>

<script>
    function fleetSynthesisWorkspace(config) {
        const alarmRank = { red: 0, orange: 1, green: 2 };
        return {
            aircraft: config.aircraft,
            taskTypeCols: config.taskTypeCols,
            includeTechLogs: config.includeTechLogs,
            dashboardRows: config.dashboardRows,
            detailsRows: config.detailsRows,
            savedViews: config.savedViews,
            detailsColumns: config.detailsColumns,
            staleThresholdDays: config.staleThresholdDays,

            // view state
            view: config.initialView,
            filterOpen: true,
            openReport: false,
            openColumns: false,
            openSaveView: false,
            openManageViews: false,
            refreshing: false,

            // filter state
            selectedAc: [],
            status: 'Applicable',
            remainingHours: '',
            remainingCycles: '',
            remainingMonths: '',

            // saved views
            activeViewId: '',
            newViewName: '',
            newViewIsDefault: false,

            // details state
            search: '',
            selected: {},
            selectedCount: 0,
            visibleColumns: [],

            alarmClasses: {
                red:    'bg-red-600 text-white',
                orange: 'bg-amber-500 text-white',
                green:  'bg-emerald-500 text-white',
            },

            init() {
                // Seed visible columns from defaults
                this.visibleColumns = this.detailsColumns.filter(c => c.default).map(c => c.key);
                // Apply default saved view if any
                const def = this.savedViews.find(v => v.is_default);
                if (def) {
                    this.activeViewId = def.id;
                    this.applyView(def.id);
                }
            },

            get dashboardColKeys() {
                const cols = ['all', ...this.taskTypeCols];
                if (this.includeTechLogs) cols.push('MEL/CFD');
                return cols;
            },

            get activeColumns() {
                return this.detailsColumns.filter(c => this.visibleColumns.includes(c.key));
            },

            get filteredDashboardRows() {
                if (this.selectedAc.length === 0) return this.dashboardRows;
                return this.dashboardRows.filter(r => r.synthesis || this.selectedAc.includes(r.reg));
            },

            get filteredDetailsRows() {
                let rows = this.detailsRows;
                if (this.selectedAc.length > 0) rows = rows.filter(r => this.selectedAc.includes(r.reg));
                if (this.search) {
                    const q = this.search.toLowerCase();
                    rows = rows.filter(r => Object.values(r).some(v => (v ?? '').toString().toLowerCase().includes(q)));
                }
                // Default sort: priority — alarm severity first, then by due date
                return [...rows].sort((a, b) => {
                    const ar = alarmRank[a.alarm] ?? 3;
                    const br = alarmRank[b.alarm] ?? 3;
                    if (ar !== br) return ar - br;
                    return (a.due_date || '').localeCompare(b.due_date || '');
                });
            },

            get alarmCounts() {
                const counts = { red: 0, orange: 0, green: 0 };
                this.filteredDetailsRows.forEach(r => { if (counts[r.alarm] !== undefined) counts[r.alarm]++; });
                return counts;
            },

            get stalestAc() {
                const list = this.selectedAc.length > 0
                    ? this.aircraft.filter(a => this.selectedAc.includes(a.reg))
                    : this.aircraft;
                const stale = list.filter(a => a.counter_age_days > this.staleThresholdDays);
                if (stale.length === 0) return null;
                return stale.sort((a, b) => b.counter_age_days - a.counter_age_days)[0];
            },

            counterFreshness(reg) {
                const ac = this.aircraft.find(a => a.reg === reg);
                return ac ? ac.counter_age_days : null;
            },

            toggleAc(reg) {
                const i = this.selectedAc.indexOf(reg);
                i === -1 ? this.selectedAc.push(reg) : this.selectedAc.splice(i, 1);
                this.activeViewId = ''; // filter changed → no longer matching a view
            },

            resetFilters() {
                this.selectedAc = [];
                this.status = 'Applicable';
                this.remainingHours = this.remainingCycles = this.remainingMonths = '';
                this.activeViewId = '';
            },

            refresh() {
                this.refreshing = true;
                setTimeout(() => this.refreshing = false, 800);
            },

            toggleColumn(key) {
                const col = this.detailsColumns.find(c => c.key === key);
                if (col?.frozen) return;
                const i = this.visibleColumns.indexOf(key);
                i === -1 ? this.visibleColumns.push(key) : this.visibleColumns.splice(i, 1);
            },

            recount() {
                this.selectedCount = Object.values(this.selected).filter(Boolean).length;
            },

            clearSelection() {
                this.selected = {};
                this.selectedCount = 0;
            },

            drillIntoDetails(reg, col, alarm) {
                if (reg !== 'All') this.selectedAc = [reg];
                this.view = this.view === 'both' ? 'both' : 'details';
                if (alarm) this.search = ''; // in production would apply alarm filter
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },

            applyView(id) {
                const v = this.savedViews.find(x => x.id === id);
                if (!v) return;
                this.selectedAc = v.filter.regs ?? [];
                this.status = v.filter.status ?? 'Applicable';
                this.remainingHours = v.filter.remainingHours ?? '';
                this.remainingCycles = v.filter.remainingCycles ?? '';
                this.remainingMonths = v.filter.remainingMonths ?? '';
                if (v.columns) this.visibleColumns = [...v.columns];
                if (v.view) this.view = v.view;
            },

            saveCurrentView() {
                const newView = {
                    id: 'v-' + Date.now(),
                    name: this.newViewName,
                    is_default: this.newViewIsDefault,
                    filter: {
                        regs: [...this.selectedAc],
                        status: this.status,
                        remainingHours: this.remainingHours,
                        remainingCycles: this.remainingCycles,
                        remainingMonths: this.remainingMonths,
                    },
                    columns: [...this.visibleColumns],
                    view: this.view,
                };
                if (newView.is_default) this.savedViews.forEach(v => v.is_default = false);
                this.savedViews.push(newView);
                this.activeViewId = newView.id;
                this.newViewName = '';
                this.newViewIsDefault = false;
                this.openSaveView = false;
            },

            setDefaultView(id) {
                this.savedViews.forEach(v => v.is_default = (v.id === id));
            },

            deleteView(id) {
                this.savedViews = this.savedViews.filter(v => v.id !== id);
                if (this.activeViewId === id) this.activeViewId = '';
            },
        };
    }
</script>
@endsection
