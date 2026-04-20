<div class="space-y-6">
    <x-page-header
        title="Pending Installed Base Updates from Work Orders"
        :description="$pageDescription"
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="attach-workspace-shell">

        {{-- ── Toolbar ── --}}
        <div class="pb-4">
            <x-enterprise.checkbox
                label="Display Open Work Orders"
                wire:model.live="displayOpenWorkOrders"
            />
        </div>

        {{-- ── Table ── --}}
        <x-enterprise.table-shell table-class="pending-base-table">
            <x-slot:thead>
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
            </x-slot:thead>
            <x-slot:tbody>
                @forelse ($rows as $row)
                    <tr wire:key="pending-installed-{{ $row['code'] }}">
                        <td><x-enterprise.table-cell variant="arrow">{{ $row['code'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['type'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['status'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['work_center'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['object_type'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell variant="arrow">{{ $row['object_ref'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['item_code'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['serial_number'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['category_part'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell variant="arrow">{{ $row['repair_event'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['start_date'] }}</x-enterprise.table-cell></td>
                        <td><x-enterprise.table-cell>{{ $row['title'] }}</x-enterprise.table-cell></td>
                        {{-- Confirm: standalone checkbox (no label needed) --}}
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
            </x-slot:tbody>
        </x-enterprise.table-shell>

        {{-- ── Footer ── --}}
        <x-enterprise.action-bar>
            <button type="button" wire:click="confirmPreview" class="btn-primary">OK</button>
            <a href="{{ $cancelRoute }}" class="btn-secondary">Cancel</a>
            <button type="button" wire:click="openFleetManagement" class="btn-secondary">Fleet Mngt...</button>
        </x-enterprise.action-bar>

    </section>
</div>
