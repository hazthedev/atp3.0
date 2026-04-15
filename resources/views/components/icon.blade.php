@props([
    'name' => 'square',
])

@php
    use Illuminate\Support\Str;

    $fallback = strtoupper(Str::substr(str_replace(['-', '_'], '', $name), 0, 1));
@endphp

<svg {{ $attributes->merge(['class' => 'h-5 w-5', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor']) }} stroke-width="1.8" aria-hidden="true">
    @switch($name)
        @case('home')
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5M5.25 9.75V20.25H18.75V9.75" />
            @break
        @case('magnifying-glass')
            <circle cx="11" cy="11" r="6" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 20L16.5 16.5" />
            @break
        @case('chevron-down')
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
            @break
        @case('chevron-right')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" />
            @break
        @case('bars-3')
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
            @break
        @case('bell')
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.5 18a2.5 2.5 0 01-5 0M5.5 16.5h13l-1.5-2.25V10a5 5 0 10-10 0v4.25L5.5 16.5z" />
            @break
        @case('plus')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
            @break
        @case('document')
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h6l3 3v13.5H7.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.75v3h3" />
            @break
        @case('lock-closed')
            <rect x="6" y="10" width="12" height="10" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 10V8a3 3 0 116 0v2" />
            @break
        @case('exclamation-triangle')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4l8 14H4L12 4z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 3h.01" />
            @break
        @case('x-circle')
            <circle cx="12" cy="12" r="8.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l6 6M15 9l-6 6" />
            @break
        @case('information-circle')
            <circle cx="12" cy="12" r="8.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v4M12 8h.01" />
            @break
        @case('check-circle')
            <circle cx="12" cy="12" r="8.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12.5l2.25 2.25 4.75-5" />
            @break
        @case('clock')
            <circle cx="12" cy="12" r="8.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5v5l3 1.5" />
            @break
        @case('chart-bar')
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5h15" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 16.5V10.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V6.75" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 16.5V12" />
            @break
        @case('cube')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75l7.5 4.5v7.5L12 20.25l-7.5-4.5v-7.5L12 3.75z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25v-7.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L12 12.75 4.5 8.25" />
            @break
        @case('wrench-screwdriver')
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.5 6.5a3.5 3.5 0 104.95 4.95l-6.2 6.2a2 2 0 11-2.83-2.83l6.2-6.2A3.48 3.48 0 0014.5 6.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 5.25l2.25 2.25M5.25 7.5L7.5 9.75" />
            @break
        @case('adjustments-horizontal')
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75h15" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 17.25h15" />
            <circle cx="9" cy="6.75" r="1.75" />
            <circle cx="15" cy="12" r="1.75" />
            <circle cx="11" cy="17.25" r="1.75" />
            @break
        @case('sliders')
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 4.5v15" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 4.5v15" />
            <circle cx="6" cy="9" r="1.75" />
            <circle cx="12" cy="14.25" r="1.75" />
            <circle cx="18" cy="8.25" r="1.75" />
            @break
        @case('paperclip')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17.25l6.9-6.9a3 3 0 10-4.24-4.24l-7.2 7.2a4.5 4.5 0 106.36 6.36l6-6" />
            @break
        @case('briefcase')
            <rect x="4.5" y="7.5" width="15" height="10.5" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7.5V6a1.5 1.5 0 011.5-1.5h3A1.5 1.5 0 0115 6v1.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 11.25h15" />
            @break
        @case('document-text')
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h6l3 3v13.5H7.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.75v3h3" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 10.5h4.5M9.75 13.5h4.5M9.75 16.5h3" />
            @break
        @case('ellipsis-horizontal-circle')
            <circle cx="12" cy="12" r="8.5" />
            <circle cx="9" cy="12" r="0.85" fill="currentColor" stroke="none" />
            <circle cx="12" cy="12" r="0.85" fill="currentColor" stroke="none" />
            <circle cx="15" cy="12" r="0.85" fill="currentColor" stroke="none" />
            @break
        @case('clipboard-document-list')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5h6a1.5 1.5 0 011.5 1.5V19.5H7.5V6A1.5 1.5 0 019 4.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 4.5a2.25 2.25 0 014.5 0" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h4.5M9.75 12.75h4.5M9.75 15.75h3.75" />
            @break
        @case('building-office-2')
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5M9 3.75H5.25A2.25 2.25 0 003 6v13.5h6V3.75zM9 21V3.75m0 0h9.75A2.25 2.25 0 0121 6v1.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 7.5h3M13.5 10.5h3M13.5 13.5h3M13.5 16.5h3" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-5.25A2.25 2.25 0 0111.25 13.5h1.5A2.25 2.25 0 0115 15.75V21" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h.75M6 10.5h.75M6 13.5h.75" />
            @break
        @case('link')
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
            @break
        @case('scissors')
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.848 8.25l1.536.887M7.848 8.25a3 3 0 11-5.196-3 3 3 0 015.196 3zm1.536.887a2.165 2.165 0 011.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 11-5.196 3 3 3 0 015.196-3zm1.536-.887a2.165 2.165 0 001.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863l2.077-1.199m0-3.328a4.323 4.323 0 012.068-1.379l5.325-1.628a4.5 4.5 0 012.48-.044l.803.215-7.794 4.5m-2.882-1.664L10.979 9.96m5.664 4.471l-5.665-3.273" />
            @break
        @case('identification')
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 9.375a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.687 15.75a4.5 4.5 0 018.626 0" />
            @break
        @case('queue-list')
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12" />
            <circle cx="4.5" cy="6.75" r="0.75" fill="currentColor" stroke="none" />
            <circle cx="4.5" cy="12" r="0.75" fill="currentColor" stroke="none" />
            <circle cx="4.5" cy="17.25" r="0.75" fill="currentColor" stroke="none" />
            @break
        @case('user-circle')
            <circle cx="12" cy="12" r="8.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.166 18.191A5.25 5.25 0 0112 15a5.25 5.25 0 015.834 3.191" />
            @break
        @case('arrow-down-tray')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v11.25M7.5 12l4.5 4.5 4.5-4.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5h15" />
            @break
        @case('arrow-up-tray')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5V8.25M7.5 12l4.5-4.5 4.5 4.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5h15" />
            @break
        @case('pencil-square')
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            @break
        @default
            <rect x="3" y="3" width="18" height="18" rx="4" />
            <text x="12" y="15.5" text-anchor="middle" fill="currentColor" font-size="8" font-weight="700">{{ $fallback }}</text>
    @endswitch
</svg>
