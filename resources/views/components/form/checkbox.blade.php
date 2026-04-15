@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'checked' => false,
])

<label class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2.5 shadow-sm">
    <input
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        type="checkbox"
        value="1"
        @checked(old($name, $checked))
        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
    />
    <span class="text-sm text-gray-700">{{ $label ?? $slot }}</span>
</label>
