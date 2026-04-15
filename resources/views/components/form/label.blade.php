@props([
    'for' => null,
    'required' => false,
])

<label @if ($for) for="{{ $for }}" @endif {{ $attributes->class('field-label') }}>
    {{ $slot }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif
</label>
