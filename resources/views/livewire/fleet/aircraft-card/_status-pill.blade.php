@php
    $status = $status ?? '';
    $tone = match (strtolower($status)) {
        'active', 'compliant', 'installed', 'serviceable', 'airworthy', 'closed', 'complete', 'completed', 'compliant.', 'ok' => 'green',
        'overdue', 'mel', 'missing', 'nok'                                                                                    => 'red',
        'planned', 'open', 'pending inspection', 'due within alarm', 'due within 30 days'                                     => 'amber',
        'draft'                                                                                                               => 'gray',
        default                                                                                                               => 'gray',
    };
    $classes = match ($tone) {
        'green' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'red'   => 'bg-red-50 text-red-700 ring-red-200',
        'amber' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'gray'  => 'bg-gray-50 text-gray-700 ring-gray-200',
    };
@endphp

<span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset {{ $classes }}">
    {{ $status }}
</span>
