<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
    <div class="flex">
        {{-- Thumbnail --}}
        <div class="hidden h-24 w-32 shrink-0 sm:block"
             style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 60%, #93c5fd 100%);">
            <div class="flex h-full items-center justify-center text-white/90">
                <x-icon name="paper-airplane" class="h-9 w-9" />
            </div>
        </div>

        {{-- Identity strip --}}
        <div class="min-w-0 flex-1 px-3 py-2">
            <div class="mb-0.5 flex items-center gap-2">
                <h2 class="text-xl font-bold text-gray-900">{{ $this->aircraft['registration'] }}</h2>
                @include('livewire.fleet.aircraft-card._status-pill', ['status' => $this->aircraft['status']])
            </div>
            <div class="mb-2 text-[11px] text-gray-600">{{ $this->aircraft['identity']['aircraft_type'] }}</div>

            <div class="overflow-x-auto">
                <dl class="grid min-w-[1100px] grid-cols-9 gap-x-4 gap-y-1 text-[11px]">
                    <div><dt class="text-gray-500">MSN</dt><dd class="font-medium text-gray-900">{{ $this->aircraft['msn'] }}</dd></div>
                    <div><dt class="text-gray-500">Registration</dt><dd class="font-medium text-gray-900">{{ $this->aircraft['registration'] }}</dd></div>
                    <div><dt class="text-gray-500">Aircraft Type</dt><dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['aircraft_type'] }}</dd></div>
                    <div><dt class="text-gray-500">Delivery Date</dt><dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['delivery_date'] }}</dd></div>
                    <div><dt class="text-gray-500">Configuration</dt><dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['configuration'] }}</dd></div>
                    <div><dt class="text-gray-500">Base</dt><dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['base'] }}</dd></div>
                    <div><dt class="text-gray-500">Maintenance Plan</dt><dd class="truncate font-medium text-gray-900" title="{{ $this->aircraft['identity']['maintenance_plan'] }}">{{ $this->aircraft['identity']['maintenance_plan'] }}</dd></div>
                    <div><dt class="text-gray-500">Owner</dt><dd class="truncate font-medium text-gray-900" title="{{ $this->aircraft['identity']['owner'] }}">{{ $this->aircraft['identity']['owner'] }}</dd></div>
                    <div><dt class="text-gray-500">Operator</dt><dd class="truncate font-medium text-gray-900" title="{{ $this->aircraft['identity']['operator'] }}">{{ $this->aircraft['identity']['operator'] }}</dd></div>
                </dl>
            </div>
        </div>

        {{-- Utilization (right-side card, inline) --}}
        <div class="hidden w-64 shrink-0 border-l border-gray-200 px-3 py-2 lg:block">
            <div class="mb-1 text-[10px] font-semibold uppercase tracking-wide text-gray-500">Utilization (Last 30 Days)</div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <div class="text-[10px] text-gray-500">Avg FH / Day</div>
                    <div class="text-lg font-bold text-blue-700">{{ number_format($this->aircraft['utilization']['avg_fh_per_day'], 2) }}</div>
                    @include('livewire.fleet.aircraft-card._sparkline', [
                        'series' => $this->aircraft['utilization']['fh_series'],
                        'color'  => '#2563eb',
                    ])
                </div>
                <div>
                    <div class="text-[10px] text-gray-500">Avg FC / Day</div>
                    <div class="text-lg font-bold text-emerald-600">{{ number_format($this->aircraft['utilization']['avg_fc_per_day'], 2) }}</div>
                    @include('livewire.fleet.aircraft-card._sparkline', [
                        'series' => $this->aircraft['utilization']['fc_series'],
                        'color'  => '#059669',
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
