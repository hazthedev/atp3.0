@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red'   => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };
@endphp

<div class="space-y-6">
    <x-page-header
        title="Change Customer Information on Functional Location"
        description="Update owner and operator details for a functional location."
    />

    @if ($statusMessage)
        <div class="flex items-center rounded-lg border p-4 text-sm {{ $statusClasses }}" role="alert">
            <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <section class="attach-workspace-shell space-y-4">

        {{-- ── Block 1: ID lookup + read-only FL fields ── --}}
        <x-enterprise.panel :muted="true" class="space-y-3">
            <x-enterprise.field-row label="ID." for="change_customer_id">
                <x-enterprise.input
                    id="change_customer_id"
                    variant="lookup"
                    wire:model.blur="functionalLocationCode"
                    wire:keydown.enter.prevent="loadFunctionalLocation"
                    class="attach-input {{ $recordLoaded ? 'border-blue-300 bg-blue-50' : '' }}"
                    placeholder="e.g. 9M-WAA"
                >
                    <x-slot:lookupAction>
                        <button
                            type="button"
                            wire:click="loadFunctionalLocation"
                            class="flex items-center justify-center text-gray-400 transition-colors hover:text-gray-700 focus:outline-none"
                        >
                            <x-icon name="magnifying-glass" class="h-4 w-4" />
                        </button>
                    </x-slot:lookupAction>
                </x-enterprise.input>
            </x-enterprise.field-row>

            @foreach ([
                ['label' => 'Serial no.', 'value' => $serialNo],
                ['label' => 'Registration', 'value' => $registration],
                ['label' => 'Type', 'value' => $type],
            ] as $field)
                <x-enterprise.field-row :label="$field['label']">
                    <x-enterprise.input variant="disabled" class="attach-input" value="{{ $field['value'] }}" />
                </x-enterprise.field-row>
            @endforeach
        </x-enterprise.panel>

        {{-- ── Block 2: Owner / Operator ── --}}
        <x-enterprise.panel :muted="true" class="space-y-3">
            <x-enterprise.field-row label="Owner code">
                <x-enterprise.input
                    variant="lookup"
                    class="attach-input"
                    wire:model.live="ownerCode"
                />
            </x-enterprise.field-row>

            <x-enterprise.field-row label="Owner name">
                <x-enterprise.input class="attach-input" wire:model.live="ownerName" />
            </x-enterprise.field-row>

            <x-enterprise.field-row label="Operator code">
                <x-enterprise.input
                    variant="lookup"
                    class="attach-input"
                    wire:model.live="operatorCode"
                />
            </x-enterprise.field-row>

            <x-enterprise.field-row label="Operator name">
                <x-enterprise.input class="attach-input" wire:model.live="operatorName" />
            </x-enterprise.field-row>
        </x-enterprise.panel>

        {{-- ── Block 3: Propagation + Date + Comment ── --}}
        <x-enterprise.panel :muted="true" class="space-y-4">
            <x-enterprise.checkbox
                label="Force owner propagation"
                wire:model.live="forceOwnerPropagation"
            />

            <x-enterprise.field-row label="Date of change">
                <x-enterprise.input
                    class="attach-input max-w-[160px]"
                    wire:model.live="dateOfChange"
                />
            </x-enterprise.field-row>

            <x-enterprise.textarea-row label="Comment" :rows="4" wire:model.live="comment" />
        </x-enterprise.panel>

        {{-- ── Footer ── --}}
        <x-enterprise.action-bar>
            <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
            <a href="{{ route('fleet.functional-location.customer') }}" class="btn-secondary">Cancel</a>
        </x-enterprise.action-bar>

    </section>
</div>
