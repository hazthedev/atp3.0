@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'error' => null,
    'required' => false,
])

<div class="space-y-1.5">
    @if ($label)
        <x-form.label :for="$id ?? $name" :required="$required">{{ $label }}</x-form.label>
    @endif

    <input
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class(['input-field', 'input-error' => filled($error)]) }}
    />

    @if ($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @endif
</div>
