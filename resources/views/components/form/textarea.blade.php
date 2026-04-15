@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'rows' => 4,
    'error' => null,
    'required' => false,
])

<div class="space-y-1.5">
    @if ($label)
        <x-form.label :for="$id ?? $name" :required="$required">{{ $label }}</x-form.label>
    @endif

    <textarea
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class(['input-field', 'input-error' => filled($error)]) }}
    >{{ old($name, $value) }}</textarea>

    @if ($error)
        <p class="text-xs text-red-600">{{ $error }}</p>
    @endif
</div>
