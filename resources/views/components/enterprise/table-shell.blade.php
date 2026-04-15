@props([
    'tableClass' => 'pending-base-table',
    'datatable' => null,
    'datatablePerPage' => 10,
    'datatablePerPageSelect' => [5, 10, 25, 50],
    'datatableFixedHeight' => false,
    'datatableSelectable' => null,
    'datatableMultiSelect' => false,
    'datatableRowNavigation' => false,
    'shell' => true,
    'minRows' => 0,
    'rowCount' => 0,
])

@php
    $tableId = 'enterprise-datatable-' . \Illuminate\Support\Str::uuid();
    $resolveBoolean = static function ($value, $fallback = null) {
        if (is_null($value)) {
            return $fallback;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            $normalized = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            return $normalized ?? ! in_array(strtolower($value), ['0', 'false', 'off', 'no'], true);
        }

        return (bool) $value;
    };
    $tableClasses = collect(preg_split('/\s+/', trim($tableClass)))->filter();
    $autoDatatable = $tableClasses->contains('pending-base-table');
    $useDatatable = $resolveBoolean($datatable, $autoDatatable);
    $enableSelectableRows = $resolveBoolean($datatableSelectable, $useDatatable);
@endphp

@if ($shell)
    <div {{ $attributes->class(['overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm']) }}>
@endif
    <div class="{{ $useDatatable ? 'datatable-host' : 'overflow-x-auto' }}">
        <table
            id="{{ $tableId }}"
            class="{{ $tableClass }}"
            @if ($useDatatable)
                data-datatable="true"
                data-datatable-per-page="{{ (int) $datatablePerPage }}"
                data-datatable-per-page-select='@json($datatablePerPageSelect)'
                data-datatable-fixed-height="{{ $datatableFixedHeight ? 'true' : 'false' }}"
                data-datatable-selectable="{{ $enableSelectableRows ? 'true' : 'false' }}"
                data-datatable-multi-select="{{ $datatableMultiSelect ? 'true' : 'false' }}"
                data-datatable-row-navigation="{{ $datatableRowNavigation ? 'true' : 'false' }}"
            @endif
        >
            @isset($thead)
                <thead>{{ $thead }}</thead>
            @endisset

            @isset($tbody)
                <tbody>
                    {{ $tbody }}
                    @for ($i = 0; $i < max(0, $minRows - $rowCount); $i++)
                        <tr class="is-empty"><td colspan="999" class="table-td">&nbsp;</td></tr>
                    @endfor
                </tbody>
            @endisset
        </table>
    </div>
@if ($shell)
    </div>
@endif
