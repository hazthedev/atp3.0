<div class="space-y-4"
     x-data="{ pickerOpen: false, actionsOpen: false, savedToast: '' }"
     x-on:aircraft-card-saved.window="savedToast = $event.detail.message; setTimeout(() => savedToast = '', 2500)">
    {{-- Page header bar --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Aircraft Card</h1>

        <div class="flex items-center gap-2">
            {{-- Aircraft picker --}}
            <div class="relative">
                <button
                    type="button"
                    @click="pickerOpen = !pickerOpen"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    <span>{{ $this->aircraft['registration'] }}</span>
                    <span class="text-xs text-gray-500">{{ $this->aircraft['identity']['aircraft_type'] }}</span>
                    <x-icon name="chevron-down" class="h-4 w-4" />
                </button>

                <div x-show="pickerOpen" @click.outside="pickerOpen = false" x-cloak
                     class="absolute right-0 z-10 mt-2 w-72 origin-top-right rounded-md border border-gray-200 bg-white shadow-lg">
                    <ul class="py-1 text-sm">
                        @foreach ($this->aircraftList as $ac)
                            <li>
                                <button
                                    type="button"
                                    wire:click="switchAircraft('{{ $ac['registration'] }}')"
                                    @click="pickerOpen = false"
                                    class="flex w-full items-center justify-between px-3 py-2 hover:bg-gray-50 {{ $ac['registration'] === $this->registration ? 'bg-blue-50 font-semibold text-blue-700' : 'text-gray-700' }}"
                                >
                                    <span class="flex items-center gap-2">
                                        <span>{{ $ac['registration'] }}</span>
                                        <span class="text-xs text-gray-500">MSN {{ $ac['msn'] }}</span>
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $ac['type'] }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                <x-icon name="document-text" class="h-4 w-4" />
                Print
            </button>
            <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                <x-icon name="document-arrow-down" class="h-4 w-4" />
                Export
            </button>

            <div class="relative">
                <button
                    type="button"
                    @click="actionsOpen = !actionsOpen"
                    class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    <x-icon name="cog-6-tooth" class="h-4 w-4" />
                    Actions
                    <x-icon name="chevron-down" class="h-3.5 w-3.5" />
                </button>
                <div x-show="actionsOpen" @click.outside="actionsOpen = false" x-cloak
                     class="absolute right-0 z-10 mt-2 w-48 rounded-md border border-gray-200 bg-white shadow-lg">
                    <ul class="py-1 text-sm text-gray-700">
                        @if (! $editMode)
                            <li>
                                <button type="button" wire:click="enableEdit" @click="actionsOpen = false"
                                        class="flex w-full items-center gap-2 px-3 py-2 hover:bg-gray-50">
                                    <x-icon name="pencil-square" class="h-4 w-4" />
                                    Edit Record
                                </button>
                            </li>
                        @endif
                        <li><button type="button" class="flex w-full items-center gap-2 px-3 py-2 text-gray-400" disabled>Generate Report</button></li>
                        <li><button type="button" class="flex w-full items-center gap-2 px-3 py-2 text-gray-400" disabled>Schedule Maintenance</button></li>
                    </ul>
                </div>
            </div>

            <div class="ml-1 flex items-center gap-3 border-l border-gray-200 pl-3">
                <button type="button" class="relative text-gray-500 hover:text-gray-700" title="Alerts">
                    <x-icon name="bell" class="h-5 w-5" />
                    <span class="absolute -right-1 -top-1 inline-flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white">3</span>
                </button>
                <button type="button" class="relative text-gray-500 hover:text-gray-700" title="Tasks">
                    <x-icon name="clipboard-document-list" class="h-5 w-5" />
                    <span class="absolute -right-1 -top-1 inline-flex h-4 min-w-[16px] items-center justify-center rounded-full bg-amber-500 px-1 text-[10px] font-semibold text-white">12</span>
                </button>
                <button type="button" class="relative text-gray-500 hover:text-gray-700" title="Messages">
                    <x-icon name="chat-bubble-solid" class="h-5 w-5" />
                    <span class="absolute -right-1 -top-1 inline-flex h-4 min-w-[16px] items-center justify-center rounded-full bg-blue-500 px-1 text-[10px] font-semibold text-white">4</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Identity card + Utilization sparklines --}}
    @include('livewire.fleet.aircraft-card._header')

    {{-- Tab navigation --}}
    <div class="flex items-end justify-between border-b border-gray-200">
        <nav class="-mb-px flex flex-wrap gap-x-1 text-sm">
            @foreach (\App\Livewire\Fleet\AircraftCardPage::TABS as $key => $label)
                <button
                    type="button"
                    wire:click="setTab('{{ $key }}')"
                    class="border-b-2 px-3 py-2 font-medium transition-colors {{ $activeTab === $key ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </nav>
        <div class="flex items-center gap-1.5 pb-2 text-xs text-gray-500">
            <span>Last updated: {{ $this->aircraft['last_updated'] }}</span>
            <button type="button" class="text-gray-400 hover:text-gray-600" title="Refresh">
                <x-icon name="arrow-path" class="h-4 w-4" />
            </button>
        </div>
    </div>

    {{-- Active tab content --}}
    <div>
        @switch($activeTab)
            @case('overview')               @include('livewire.fleet.aircraft-card.overview', ['data' => $this->aircraft]) @break
            @case('general')                @include('livewire.fleet.aircraft-card.general', ['data' => $this->aircraft]) @break
            @case('configuration')          @include('livewire.fleet.aircraft-card.configuration', ['data' => $this->aircraft]) @break
            @case('counters')               @include('livewire.fleet.aircraft-card.counters', ['data' => $this->aircraft]) @break
            @case('maintenance')            @include('livewire.fleet.aircraft-card.maintenance', ['data' => $this->aircraft]) @break
            @case('technical-publications') @include('livewire.fleet.aircraft-card.technical-publications', ['data' => $this->aircraft]) @break
            @case('defects')                @include('livewire.fleet.aircraft-card.defects', ['data' => $this->aircraft]) @break
            @case('work-package')           @include('livewire.fleet.aircraft-card.work-package', ['data' => $this->aircraft]) @break
            @case('journey-logs')           @include('livewire.fleet.aircraft-card.journey-logs', ['data' => $this->aircraft]) @break
            @case('events')                 @include('livewire.fleet.aircraft-card.events', ['data' => $this->aircraft]) @break
        @endswitch
    </div>

    <div x-show="savedToast" x-cloak
         class="fixed bottom-4 right-4 rounded-md bg-green-600 px-4 py-2 text-sm text-white shadow-lg"
         x-text="savedToast"></div>
</div>
