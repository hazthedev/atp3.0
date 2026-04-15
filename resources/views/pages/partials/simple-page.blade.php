@php
    $sections = $sections ?? [
        [
            'title' => 'Operational preview',
            'body' => 'This page is scaffolded as part of the Laravel frontend rewrite and currently displays placeholder content only.',
        ],
        [
            'title' => 'What comes next',
            'body' => 'Backend integrations will replace these static cards with live data, role-aware actions, and persisted filters.',
        ],
        [
            'title' => 'Design intent',
            'body' => 'The layout already matches the reusable ATP component system so future functionality can be layered in without a visual rewrite.',
        ],
    ];
@endphp

<div class="space-y-6">
    <x-page-header :title="$title" :description="$description" />

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($sections as $section)
            <x-card :title="$section['title']">
                <p class="text-sm leading-6 text-gray-600">{{ $section['body'] }}</p>
            </x-card>
        @endforeach
    </div>
</div>
