@php
    use Illuminate\Support\Str;

    $sections = $sections ?? [
        [
            'title' => 'Identity',
            'description' => 'Capture the primary reference details used throughout the module.',
            'fields' => [
                ['component' => 'input', 'label' => 'Name', 'name' => Str::slug($title) . '_name', 'placeholder' => 'Enter a descriptive name'],
                ['component' => 'input', 'label' => 'Code', 'name' => Str::slug($title) . '_code', 'placeholder' => 'Auto-generated or manual code'],
                ['component' => 'select', 'label' => 'Status', 'name' => Str::slug($title) . '_status', 'options' => ['active' => 'Active', 'planned' => 'Planned', 'draft' => 'Draft']],
            ],
        ],
        [
            'title' => 'Planning',
            'description' => 'Align ownership, scheduling, and operational context.',
            'fields' => [
                ['component' => 'input', 'label' => 'Owner', 'name' => Str::slug($title) . '_owner', 'placeholder' => 'Responsible person or team'],
                ['component' => 'input', 'type' => 'date', 'label' => 'Effective Date', 'name' => Str::slug($title) . '_date'],
                ['component' => 'checkbox', 'label' => 'Flag for review during backend integration', 'name' => Str::slug($title) . '_review'],
            ],
        ],
        [
            'title' => 'Notes',
            'description' => 'Add implementation notes or operational comments for later phases.',
            'fields' => [
                ['component' => 'textarea', 'label' => 'Summary', 'name' => Str::slug($title) . '_summary', 'placeholder' => 'Capture supporting notes for this preview form.', 'rows' => 5],
            ],
        ],
    ];
@endphp

<div class="space-y-6">
    <x-page-header :title="$title" :description="$description" />

    <div class="grid gap-6 lg:grid-cols-2">
        @foreach ($sections as $section)
            <x-card :title="$section['title']" :description="$section['description'] ?? null">
                <div class="space-y-4">
                    @foreach ($section['fields'] as $field)
                        @switch($field['component'])
                            @case('textarea')
                                <x-form.textarea
                                    :label="$field['label']"
                                    :name="$field['name']"
                                    :placeholder="$field['placeholder'] ?? null"
                                    :rows="$field['rows'] ?? 4"
                                />
                                @break
                            @case('select')
                                <x-form.select
                                    :label="$field['label']"
                                    :name="$field['name']"
                                    :options="$field['options'] ?? []"
                                    :placeholder="$field['placeholder'] ?? 'Select an option'"
                                />
                                @break
                            @case('checkbox')
                                <x-form.checkbox :label="$field['label']" :name="$field['name']" />
                                @break
                            @default
                                <x-form.input
                                    :label="$field['label']"
                                    :name="$field['name']"
                                    :type="$field['type'] ?? 'text'"
                                    :placeholder="$field['placeholder'] ?? null"
                                />
                        @endswitch
                    @endforeach
                </div>
            </x-card>
        @endforeach
    </div>

    <div class="sticky-form-actions">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" class="btn-secondary">Cancel</a>
        <button type="button" class="btn-primary">Save preview</button>
    </div>
</div>
