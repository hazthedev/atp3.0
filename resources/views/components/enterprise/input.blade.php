@props([
    'type'    => 'text',
    'placeholder' => '',
    'variant' => null,  {{-- null | 'lookup' | 'arrow-lookup' | 'indicator' | 'arrow-indicator' | 'tree' | 'disabled' | 'cell' --}}
    'tone'    => null,  {{-- for indicator: 'green' | 'amber' | 'red' --}}
])

@php
    $base = 'input-field';

    $indicatorClass = match ($tone) {
        'green' => 'border-emerald-400 bg-emerald-50',
        'amber' => 'border-amber-400 bg-amber-50',
        'red'   => 'border-red-400 bg-red-50',
        default => 'border-amber-400 bg-amber-50',
    };

    $iconBtn = 'flex items-center justify-center text-gray-400 transition-colors hover:text-gray-700 focus:outline-none';

    // Borderless input sized for a <td> in an inline-edit grid. Mirrors the
    // raw pattern in counter-ref-manager / measure-unit-manager /
    // mro-status-object-manager so those pages can migrate without visual
    // regression.
    $cellClass = 'w-full border-0 bg-transparent px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 read-only:cursor-not-allowed read-only:text-gray-500 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-100';
@endphp

@if ($variant === 'arrow-lookup')
    <div class="relative">
        {{-- Left arrow button --}}
        <div class="absolute inset-y-0 left-0 flex items-center pl-2.5">
            @isset($arrowAction)
                {{ $arrowAction }}
            @else
                <button type="button" class="{{ $iconBtn }}">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
                    </svg>
                </button>
            @endisset
        </div>

        <input
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->class([$base, 'pl-8 pr-9']) }}
        />

        {{-- Right lookup button --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5">
            @isset($lookupAction)
                {{ $lookupAction }}
            @else
                <button type="button" class="{{ $iconBtn }}">
                    <x-icon name="magnifying-glass" class="h-4 w-4" />
                </button>
            @endisset
        </div>
    </div>

@elseif ($variant === 'lookup')
    <div class="relative">
        <input
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->class([$base, 'pr-9']) }}
        />

        {{-- Right lookup button --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5">
            @isset($lookupAction)
                {{ $lookupAction }}
            @else
                <button type="button" class="{{ $iconBtn }}">
                    <x-icon name="magnifying-glass" class="h-4 w-4" />
                </button>
            @endisset
        </div>
    </div>

@elseif ($variant === 'tree')
    <div class="relative">
        <input
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->class([$base, 'pr-9']) }}
        />

        {{-- Right tree button --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5">
            @isset($treeAction)
                {{ $treeAction }}
            @else
                <button type="button" class="{{ $iconBtn }}">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 8">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7 7.674 1.3a.91.91 0 0 0-1.348 0L1 7"/>
                    </svg>
                </button>
            @endisset
        </div>
    </div>

@elseif ($variant === 'arrow-indicator')
    <div class="relative">
        {{-- Left arrow button --}}
        <div class="absolute inset-y-0 left-0 flex items-center pl-2.5">
            @isset($arrowAction)
                {{ $arrowAction }}
            @else
                <button type="button" class="{{ $iconBtn }}">
                    <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
                    </svg>
                </button>
            @endisset
        </div>

        <input
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->class([$base, $indicatorClass, 'pl-8']) }}
        />
    </div>

@elseif ($variant === 'indicator')
    <input
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class([$base, $indicatorClass]) }}
    />

@elseif ($variant === 'disabled')
    <input
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        disabled
        {{ $attributes->class([$base]) }}
    />

@elseif ($variant === 'cell')
    <input
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class([$cellClass]) }}
    />

@else
    <input
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class([$base]) }}
    />
@endif
