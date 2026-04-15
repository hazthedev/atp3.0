@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };
@endphp

<div class="space-y-6">
    <x-page-header
        title="Pending Installed Base Updates from Work Orders"
        :description="$pageDescription"
    />

    @if ($statusMessage)
        <div class="rounded-xl border px-4 py-3 text-sm font-medium {{ $statusClasses }}">
            {{ $statusMessage }}
        </div>
    @endif

    <section class="attach-workspace-shell max-w-full">
        <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
            <label class="attach-checkbox-row">
                <input type="checkbox" wire:model.live="displayOpenWorkOrders" />
                <span>Display Open Work Orders</span>
            </label>
            <p class="text-sm text-gray-500">Toggle the list to focus only on rows marked for open-work-order review.</p>
        </div>

        <x-enterprise.table-shell table-class="pending-base-table">
            <x-slot name="thead">
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Work Center</th>
                    <th>Object Type</th>
                    <th>Object Ref</th>
                    <th>Item Code / FL Ref</th>
                    <th>Serial Number</th>
                    <th>Categ. Part / Ref</th>
                    <th>Repair Event</th>
                    <th>Start Date</th>
                    <th>Title</th>
                    <th class="text-center">Confirm</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($rows as $row)
                    <tr wire:key="pending-installed-{{ $row['code'] }}">
                        <td>
                            <a href="#" class="inline-flex items-center gap-2 font-semibold text-gray-900 transition hover:text-blue-700">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                </span>
                                <span>{{ $row['code'] }}</span>
                            </a>
                        </td>
                        <td>{{ $row['type'] }}</td>
                        <td>{{ $row['status'] }}</td>
                        <td>{{ $row['work_center'] }}</td>
                        <td>{{ $row['object_type'] }}</td>
                        <td>
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-700">{{ $row['object_ref'] }}</a>
                        </td>
                        <td>{{ $row['item_code'] }}</td>
                        <td>{{ $row['serial_number'] }}</td>
                        <td>{{ $row['category_part'] }}</td>
                        <td>
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-700">{{ $row['repair_event'] }}</a>
                        </td>
                        <td>{{ $row['start_date'] }}</td>
                        <td>{{ $row['title'] }}</td>
                        <td class="text-center">
                            <input
                                type="checkbox"
                                wire:model.live="confirmed.{{ $row['code'] }}"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="py-10 text-center text-sm text-gray-500">
                            No pending installed-base updates matched the current view.
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-enterprise.table-shell>

        <x-enterprise.action-bar>
            <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
            <a href="{{ $cancelRoute }}" class="btn-secondary">Cancel</a>
            <button type="button" wire:click="openFleetManagement" class="btn-secondary">Fleet Mngt...</button>
        </x-enterprise.action-bar>
    </section>
</div>
