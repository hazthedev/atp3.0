@props([
    'id',
    'name' => null,
    'value' => '',
    'placeholder' => 'Select date',
])

@php
    $fieldId = $id ?? $name ?? 'date-picker-' . uniqid();
@endphp

<div
    x-data="{
        value: @js($value),
        syncFromInput() {
            this.value = this.$refs.input?.value ?? '';
        },
    }"
    x-modelable="value"
    x-init="
        $nextTick(() => {
            if ($refs.input && value) {
                $refs.input.value = value;
            }

            const sync = () => syncFromInput();

            ['changeDate', 'change', 'input', 'blur'].forEach((eventName) => {
                $refs.input?.addEventListener(eventName, sync);
            });

            const observer = new MutationObserver(sync);
            observer.observe($refs.input, { attributes: true, attributeFilter: ['value'] });

            $watch('value', (nextValue) => {
                if ($refs.input && $refs.input.value !== (nextValue ?? '')) {
                    $refs.input.value = nextValue ?? '';
                }
            });
        });
    "
    {{ $attributes->except(['x-model'])->class(['relative w-full']) }}
>
    <div class="relative w-full">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-gray-500">
            <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
            </svg>
        </div>

        <input
            id="{{ $fieldId }}"
            @if ($name) name="{{ $name }}" @endif
            type="text"
            datepicker
            datepicker-autohide
            datepicker-buttons
            datepicker-format="yyyy-mm-dd"
            placeholder="{{ $placeholder }}"
            x-ref="input"
            :value="value"
            autocomplete="off"
            class="block w-full ps-9 pe-3 py-2.5 input-field attach-input"
        />
    </div>
</div>
