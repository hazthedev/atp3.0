@props([
    'rows' => 3,
])

<textarea rows="{{ $rows }}" {{ $attributes->class(['input-field min-h-[64px] resize-none rounded-lg px-3 py-2']) }}>{{ $slot }}</textarea>
