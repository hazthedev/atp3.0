<div class="space-y-3"
     x-data="{ pickerOpen: false, actionsOpen: false, savedToast: '' }"
     x-on:aircraft-card-saved.window="savedToast = $event.detail.message; setTimeout(() => savedToast = '', 2500)">
    {{-- Identity card --}}
    @include('livewire.fleet.aircraft-card._header')

    {{-- Tab nav + actions row --}}
    <div class="flex items-center justify-between gap-2 overflow-x-auto border-b border-gray-200">
        <nav class="-mb-px flex flex-nowrap text-[12px]">
            @foreach (\App\Livewire\Fleet\AircraftCardPage::TABS as $key => $label)
                <button
                    type="button"
                    wire:click="setTab('{{ $key }}')"
                    class="whitespace-nowrap border-b-2 px-3 py-2 font-medium transition-colors {{ $activeTab === $key ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}"
                >{{ $label }}</button>
            @endforeach
        </nav>

        <div class="flex shrink-0 items-center gap-1.5 pb-1.5">
            {{-- Aircraft picker --}}
            <div class="relative">
                <button type="button" @click="pickerOpen = !pickerOpen"
                        class="inline-flex items-center gap-1.5 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <span>{{ $this->aircraft['registration'] }}</span>
                    <span class="text-[10px] text-gray-500">{{ $this->aircraft['identity']['aircraft_type'] }}</span>
                    <x-icon name="chevron-down" class="h-3 w-3" />
                </button>
                <div x-show="pickerOpen" @click.outside="pickerOpen = false" x-cloak
                     class="absolute right-0 z-10 mt-1 w-64 origin-top-right rounded border border-gray-200 bg-white shadow-lg">
                    <ul class="py-1 text-[11px]">
                        @foreach ($this->aircraftList as $ac)
                            <li>
                                <button type="button" wire:click="switchAircraft('{{ $ac['registration'] }}')" @click="pickerOpen = false"
                                        class="flex w-full items-center justify-between px-2.5 py-1.5 hover:bg-gray-50 {{ $ac['registration'] === $this->registration ? 'bg-blue-50 font-semibold text-blue-700' : 'text-gray-700' }}">
                                    <span class="flex items-center gap-2">
                                        <span>{{ $ac['registration'] }}</span>
                                        <span class="text-[10px] text-gray-500">MSN {{ $ac['msn'] }}</span>
                                    </span>
                                    <span class="text-[10px] text-gray-500">{{ $ac['type'] }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <button type="button" class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 shadow-sm hover:bg-gray-50" title="Print">
                <x-icon name="document-text" class="h-3.5 w-3.5" /> Print
            </button>
            <button type="button" class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 shadow-sm hover:bg-gray-50" title="Export">
                <x-icon name="document-arrow-down" class="h-3.5 w-3.5" /> Export
            </button>

            <div class="relative">
                <button type="button" @click="actionsOpen = !actionsOpen"
                        class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-[11px] font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <x-icon name="cog-6-tooth" class="h-3.5 w-3.5" /> Actions
                    <x-icon name="chevron-down" class="h-3 w-3" />
                </button>
                <div x-show="actionsOpen" @click.outside="actionsOpen = false" x-cloak
                     class="absolute right-0 z-10 mt-1 w-44 rounded border border-gray-200 bg-white shadow-lg">
                    <ul class="py-1 text-[11px] text-gray-700">
                        @if (! $editMode)
                            <li>
                                <button type="button" wire:click="enableEdit" @click="actionsOpen = false"
                                        class="flex w-full items-center gap-2 px-2.5 py-1.5 hover:bg-gray-50">
                                    <x-icon name="pencil-square" class="h-3.5 w-3.5" /> Edit Record
                                </button>
                            </li>
                        @endif
                        <li><button type="button" class="flex w-full items-center gap-2 px-2.5 py-1.5 text-gray-400" disabled>Generate Report</button></li>
                        <li><button type="button" class="flex w-full items-center gap-2 px-2.5 py-1.5 text-gray-400" disabled>Schedule Maintenance</button></li>
                    </ul>
                </div>
            </div>

            <span class="ml-1 hidden text-[10px] text-gray-500 md:inline">Updated {{ $this->aircraft['last_updated'] }}</span>
            <button type="button" class="text-gray-400 hover:text-gray-600" title="Refresh">
                <x-icon name="arrow-path" class="h-3.5 w-3.5" />
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
         class="fixed bottom-4 right-4 rounded bg-green-600 px-3 py-1.5 text-[12px] text-white shadow-lg"
         x-text="savedToast"></div>
</div>
