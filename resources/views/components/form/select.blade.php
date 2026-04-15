@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'Select an option',
    'error' => null,
    'required' => false,
])

<div class="space-y-1.5">
    @if ($label)
        <x-form.label :for="$id ?? $name" :required="$required">{{ $label }}</x-form.label>
    @endif

    <select id="{{ $id ?? $name }}" name="{{ $name }}" {{ $attributes->class(['input-field', 'input-error' => filled($error)]) }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) $optionValue === (string) old($name, $value))>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @if ($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @endif
</div>
