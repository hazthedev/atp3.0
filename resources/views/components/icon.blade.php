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
        @case('id-card')
            <g transform="scale(1.3333, 1.2)">
                <path fill="currentColor" stroke="none" d="M16 0H4a2 2 0 0 0-2 2v1H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3 3 0 1 1 0 6 3 3 0 0 1 0-6ZM13.929 17H7.071a.5.5 0 0 1-.5-.5 3.935 3.935 0 1 1 7.858 0 .5.5 0 0 1-.5.5Z" />
            </g>
            @break
        @case('sliders-h')
            <g transform="scale(1.2)">
                <path fill="currentColor" stroke="none" d="M1 5h1.424a3.228 3.228 0 0 0 6.152 0H19a1 1 0 1 0 0-2H8.576a3.228 3.228 0 0 0-6.152 0H1a1 1 0 1 0 0 2Zm18 4h-1.424a3.228 3.228 0 0 0-6.152 0H1a1 1 0 1 0 0 2h10.424a3.228 3.228 0 0 0 6.152 0H19a1 1 0 0 0 0-2Zm0 6H8.576a3.228 3.228 0 0 0-6.152 0H1a1 1 0 0 0 0 2h1.424a3.228 3.228 0 0 0 6.152 0H19a1 1 0 0 0 0-2Z" />
            </g>
            @break
        @case('chat-bubble-solid')
            <g transform="scale(1.2, 1.3333)">
                <path fill="currentColor" stroke="none" d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3.546l3.2 3.659a1 1 0 0 0 1.506 0L13.454 14H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-8 10H5a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Zm5-4H5a1 1 0 0 1 0-2h10a1 1 0 1 1 0 2Z" />
            </g>
            @break
        @case('mro-receipt')
            <g transform="scale(1.0909, 1.2632)">
                <path fill="currentColor" stroke="none" d="M5.022 4.764c.489 0 .75-.37.8-.856l.188-1.877A.952.952 0 0 0 5.063.985H2.791a1.127 1.127 0 0 0-1.067.749A16.11 16.11 0 0 0 1 7a16.737 16.737 0 0 0 .743 5.242c.154.463 1.748.773 2.236.773H5a.95.95 0 0 0 .946-1.046l-.188-1.877a.95.95 0 0 0-.946-.856h-.761A14.627 14.627 0 0 1 3.937 7c-.02-.747.019-1.495.114-2.236h.971Zm13.365 7.592L18.6 11H14a1 1 0 0 1 0-2h4.918l.159-1H14a1 1 0 1 1 0-2h5.393l.158-1H14a1 1 0 1 1 0-2h5.868l.111-.7a2.04 2.04 0 0 0-.473-1.629A1.912 1.912 0 0 0 18.063 0H9a1 1 0 0 0-1 1v11.78A2.985 2.985 0 0 0 7 15v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a2.991 2.991 0 0 0-1.613-2.644Z" />
            </g>
            @break
        @case('book-solid')
            <g transform="scale(1.5, 1.2)">
                <path fill="currentColor" stroke="none" d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z" />
            </g>
            @break
        @case('badge-verified')
            <g transform="scale(1.2)">
                <path fill="currentColor" stroke="none" d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z" />
                <path fill="white" stroke="none" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z" />
            </g>
            @break
        @case('calendar-edit')
            <g transform="scale(1.2)">
                <path fill="currentColor" stroke="none" d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z" />
                <path fill="currentColor" stroke="none" d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z" />
            </g>
            @break
        @case('megaphone-solid')
            <g transform="scale(1.3333, 1.2632)">
                <path fill="currentColor" stroke="none" d="M15 1.943v12.114a1 1 0 0 1-1.581.814L8 11V5l5.419-3.871A1 1 0 0 1 15 1.943ZM7 4H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2v5a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V4ZM4 17v-5h1v5H4ZM16 5.183v5.634a2.984 2.984 0 0 0 0-5.634Z" />
            </g>
            @break
        @case('squares-2x2')
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            @break
        @case('cog-6-tooth')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            @break
        @case('arrows-right-left')
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
            @break
        @case('document-arrow-down')
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            @break
        @case('eye')
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            @break
        @case('sparkles')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
            @break
        @case('map-pin')
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
            @break
        @case('arrow-path')
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            @break
        @case('calendar-days')
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
            @break
        @case('clipboard-document-check')
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
            @break
        @case('beaker')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.769 0-5.536-.31-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
            @break
        @case('document-chart-bar')
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h6l3 3v13.5H7.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.75v3h3" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 16.5v-3M12.5 16.5v-5M15 16.5v-1.5" />
            @break
        @case('archive-box')
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            @break
        @case('star')
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
            @break
        @case('paper-airplane')
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
            @break
        @default
            <rect x="3" y="3" width="18" height="18" rx="4" />
            <text x="12" y="15.5" text-anchor="middle" fill="currentColor" font-size="8" font-weight="700">{{ $fallback }}</text>
    @endswitch
</svg>
