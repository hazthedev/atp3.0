<div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_320px]">
    {{-- Identity card --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex">
            <div class="hidden h-32 w-44 shrink-0 bg-cover bg-center sm:block"
                 style="background-image: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 60%, #93c5fd 100%);">
                <div class="flex h-full items-center justify-center text-white/90">
                    <x-icon name="paper-airplane" class="h-12 w-12" />
                </div>
            </div>
            <div class="flex-1 p-4">
                <div class="mb-2 flex items-center gap-2">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $this->aircraft['registration'] }}</h2>
                    @include('livewire.fleet.aircraft-card._status-pill', ['status' => $this->aircraft['status']])
                </div>
                <div class="mb-3 text-sm text-gray-600">{{ $this->aircraft['identity']['aircraft_type'] }}</div>

                <dl class="grid grid-cols-3 gap-x-6 gap-y-2 text-xs sm:grid-cols-9">
                    <div>
                        <dt class="text-gray-500">MSN</dt>
                        <dd class="font-medium text-gray-900">{{ $this->aircraft['msn'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Registration</dt>
                        <dd class="font-medium text-gray-900">{{ $this->aircraft['registration'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Aircraft Type</dt>
                        <dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['aircraft_type'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Delivery Date</dt>
                        <dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['delivery_date'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Configuration</dt>
                        <dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['configuration'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Base</dt>
                        <dd class="font-medium text-gray-900">{{ $this->aircraft['identity']['base'] }}</dd>
                    </div>
                    <div class="col-span-1 sm:col-span-1">
                        <dt class="text-gray-500">Maintenance Plan</dt>
                        <dd class="truncate font-medium text-gray-900" title="{{ $this->aircraft['identity']['maintenance_plan'] }}">{{ $this->aircraft['identity']['maintenance_plan'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Owner</dt>
                        <dd class="truncate font-medium text-gray-900" title="{{ $this->aircraft['identity']['owner'] }}">{{ $this->aircraft['identity']['owner'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Operator</dt>
                        <dd class="truncate font-medium text-gray-900" title="{{ $this->aircraft['identity']['operator'] }}">{{ $this->aircraft['identity']['operator'] }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    {{-- Utilization card --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Utilization (Last 30 Days)</div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-xs text-gray-500">Avg FH / Day</div>
                <div class="text-2xl font-bold text-blue-700">{{ number_format($this->aircraft['utilization']['avg_fh_per_day'], 2) }}</div>
                @include('livewire.fleet.aircraft-card._sparkline', [
                    'series' => $this->aircraft['utilization']['fh_series'],
                    'color' => '#2563eb',
                ])
            </div>
            <div>
                <div class="text-xs text-gray-500">Avg FC / Day</div>
                <div class="text-2xl font-bold text-emerald-600">{{ number_format($this->aircraft['utilization']['avg_fc_per_day'], 2) }}</div>
                @include('livewire.fleet.aircraft-card._sparkline', [
                    'series' => $this->aircraft['utilization']['fc_series'],
                    'color' => '#059669',
                ])
            </div>
        </div>
    </div>
</div>
