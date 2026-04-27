<div class="grid gap-6 md:grid-cols-2">
    {{-- Roles --}}
    <div class="space-y-3">
        <p class="text-sm font-semibold text-gray-900 underline-offset-2 underline decoration-1">Roles</p>
        <x-data-table>
            <x-slot name="thead">
                <tr>
                    <th class="table-th w-12">#</th>
                    <th class="table-th">Role</th>
                    <th class="table-th w-24"></th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($roles as $idx => $role)
                    <tr class="table-row" wire:key="role-{{ $role->id }}">
                        <td class="table-td">{{ $idx + 1 }}</td>
                        <td class="table-td">
                            {{ $role->role }}
                            @if ($role->is_default)
                                <span class="ml-2 inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-medium text-emerald-700">Default</span>
                            @endif
                        </td>
                        <td class="table-td text-right">
                            <button type="button"
                                    class="text-xs text-red-600 hover:text-red-800"
                                    wire:click="deleteRole({{ $role->id }})"
                                    wire:confirm="Remove this role?">
                                Remove
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-sm text-gray-500">No roles assigned.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>

        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-2">
            <x-enterprise.input wire:model="newRole" placeholder="Add a role..." />
            <button type="button" class="btn-secondary" wire:click="addRole">Add</button>
        </div>

        @if ($roles->isNotEmpty())
            <div class="flex flex-wrap items-center gap-2 pt-1">
                <span class="text-xs text-gray-500">Set as default:</span>
                @foreach ($roles as $role)
                    @unless ($role->is_default)
                        <button type="button"
                                class="rounded border border-gray-300 px-2 py-1 text-xs text-gray-700 hover:bg-gray-50"
                                wire:click="setRoleAsDefault({{ $role->id }})">
                            {{ $role->role }}
                        </button>
                    @endunless
                @endforeach
            </div>
        @endif
    </div>

    {{-- Teams --}}
    <div class="space-y-3">
        <p class="text-sm font-semibold text-gray-900 underline-offset-2 underline decoration-1">Teams</p>
        <x-data-table>
            <x-slot name="thead">
                <tr>
                    <th class="table-th w-12">#</th>
                    <th class="table-th">Team</th>
                    <th class="table-th">Team Role</th>
                    <th class="table-th w-24"></th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($teams as $idx => $team)
                    <tr class="table-row" wire:key="team-{{ $team->id }}">
                        <td class="table-td">{{ $idx + 1 }}</td>
                        <td class="table-td">{{ $team->team }}</td>
                        <td class="table-td">{{ $team->team_role ?? '—' }}</td>
                        <td class="table-td text-right">
                            <button type="button"
                                    class="text-xs text-red-600 hover:text-red-800"
                                    wire:click="deleteTeam({{ $team->id }})"
                                    wire:confirm="Remove this team membership?">
                                Remove
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-sm text-gray-500">No team memberships.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>

        <div class="grid grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto] items-center gap-2">
            <x-enterprise.input wire:model="newTeam" placeholder="Team..." />
            <x-enterprise.input wire:model="newTeamRole" placeholder="Team role (optional)..." />
            <button type="button" class="btn-secondary" wire:click="addTeam">Add</button>
        </div>
    </div>
</div>
