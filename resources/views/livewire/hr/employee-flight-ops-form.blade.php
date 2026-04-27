<div x-data="{ subTab: 'crew' }">
    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 pt-3 mb-5">
        <div class="subtab-shell">
            <ul class="subtab-list">
                <li class="subtab-item">
                    <button type="button" class="subtab-link"
                            :class="subTab === 'crew' ? 'subtab-link-active' : 'subtab-link-inactive'"
                            @click="subTab = 'crew'">
                        Crew Management
                    </button>
                </li>
                <li class="subtab-item">
                    <button type="button" class="subtab-link"
                            :class="subTab === 'assignment' ? 'subtab-link-active' : 'subtab-link-inactive'"
                            @click="subTab = 'assignment'">
                        Employee Assignment
                    </button>
                </li>
            </ul>
        </div>
    </div>

    {{-- Crew Management sub-tab — Positions --}}
    <div x-cloak x-show="subTab === 'crew'" class="space-y-4">
        <p class="text-sm font-semibold text-gray-900 underline-offset-2 underline decoration-1">Positions</p>
        <x-data-table>
            <x-slot name="thead">
                <tr>
                    <th class="table-th w-12">#</th>
                    <th class="table-th">Position</th>
                    <th class="table-th w-24"></th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($positions as $idx => $pos)
                    <tr class="table-row" wire:key="position-{{ $pos->id }}">
                        <td class="table-td">{{ $idx + 1 }}</td>
                        <td class="table-td">{{ $pos->position }}</td>
                        <td class="table-td text-right">
                            <button type="button"
                                    class="text-xs text-red-600 hover:text-red-800"
                                    wire:click="deletePosition({{ $pos->id }})"
                                    wire:confirm="Remove this position?">
                                Remove
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-sm text-gray-500">No positions assigned.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>

        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-2 max-w-2xl">
            <x-enterprise.input wire:model="newPosition" placeholder="Add a position..." />
            <button type="button" class="btn-secondary" wire:click="addPosition">Add</button>
        </div>

        <div class="pt-3">
            <button type="button" class="btn-secondary" disabled>Synthesis</button>
        </div>
    </div>

    {{-- Employee Assignment sub-tab --}}
    <div x-cloak x-show="subTab === 'assignment'" class="space-y-4">
        <x-data-table>
            <x-slot name="thead">
                <tr>
                    <th class="table-th w-12">#</th>
                    <th class="table-th">Assignment</th>
                    <th class="table-th w-24"></th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($assignments as $idx => $assn)
                    <tr class="table-row" wire:key="assignment-{{ $assn->id }}">
                        <td class="table-td">{{ $idx + 1 }}</td>
                        <td class="table-td">{{ $assn->assignment }}</td>
                        <td class="table-td text-right">
                            <button type="button"
                                    class="text-xs text-red-600 hover:text-red-800"
                                    wire:click="deleteAssignment({{ $assn->id }})"
                                    wire:confirm="Remove this assignment?">
                                Remove
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-sm text-gray-500">No assignments recorded.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>

        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-start gap-2">
            <x-enterprise.textarea wire:model="newAssignment" rows="3" placeholder="Describe the assignment..." />
            <button type="button" class="btn-secondary self-start" wire:click="addAssignment">New</button>
        </div>
    </div>
</div>
