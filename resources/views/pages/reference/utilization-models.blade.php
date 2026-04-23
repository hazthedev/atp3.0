@extends('layouts.app')

@section('title', 'Utilization Models')

@section('content')
    @php
        $models = App\Models\UtilizationModel::with('rates.measureUnit')->orderBy('registration')->get();
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    @endphp

    <div class="space-y-6">
        <x-page-header
            title="Utilization Models"
            description="Per-aircraft monthly utilisation rates. Used by Fleet Synthesis to convert Hours/Cycles remaining into a calendar Due Date (spec Notes 4.1–4.3)."
        >
            <x-slot name="actions">
                <span class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                    <x-icon name="document" class="h-3.5 w-3.5" />
                    Source: @MRO_OUTM + @MRO_UTM2
                </span>
                <span class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">{{ $models->count() }} aircraft</span>
            </x-slot>
        </x-page-header>

        @forelse ($models as $m)
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <header class="flex items-center justify-between border-b border-gray-100 px-5 py-3">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">{{ $m->registration }}</h3>
                        <p class="text-xs text-gray-500">Code: <code>{{ $m->code }}</code> · {{ $m->rates->count() }} rate rows</p>
                    </div>
                </header>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                                <th class="px-3 py-2">Measure Unit</th>
                                @foreach ($months as $mo)
                                    <th class="px-3 py-2 text-right">{{ $mo }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($m->rates as $rate)
                                <tr class="border-t border-gray-100">
                                    <td class="px-3 py-2">
                                        <span class="font-medium text-gray-900">{{ optional($rate->measureUnit)->designation ?? $rate->measure_unit_code }}</span>
                                    </td>
                                    @foreach (['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'] as $col)
                                        <td class="px-3 py-2 text-right font-mono text-gray-700">{{ number_format($rate->$col) }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr><td colspan="13" class="px-3 py-3 text-center text-sm text-gray-400">No rates for this aircraft.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        @empty
            <x-empty-state label="No utilization models" description="Run the database seeder to populate @MRO_OUTM and @MRO_UTM2." />
        @endforelse
    </div>
@endsection
