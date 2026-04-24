<div>
    <x-page-header title="User Groups" description="Manage authorization groups and their members.">
        <x-slot name="actions">
            <button type="button" wire:click="createGroup" class="btn-secondary">
                <x-icon name="plus" class="h-4 w-4" />
                Create Group
            </button>
        </x-slot>
    </x-page-header>

    <div class="mt-6 grid gap-6 xl:grid-cols-[300px_minmax(0,1fr)]">
        {{-- Left rail --}}
        <x-card padding="p-0">
            <div class="space-y-3 border-b border-gray-200 p-4">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Group Type</label>
                <select wire:model.live="filterType" class="input-field">
                    @foreach ($groupTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                    <option value="__cross__">Cross All Types</option>
                </select>
            </div>

            <div class="max-h-[70vh] overflow-y-auto">
                @forelse ($groups as $g)
                    <button
                        type="button"
                        wire:click="selectGroup({{ $g->id }})"
                        class="flex w-full items-center justify-between border-b border-gray-100 px-4 py-3 text-left text-sm transition hover:bg-blue-50 {{ $selectedGroupId === $g->id ? 'bg-blue-50 font-semibold text-blue-700' : 'text-gray-700' }}"
                    >
                        <span class="truncate">{{ $loop->iteration }}. {{ $g->name }}</span>
                        @if ($selectedGroupId === $g->id)
                            <x-icon name="chevron-right" class="h-4 w-4 text-blue-500" />
                        @endif
                    </button>
                @empty
                    <p class="px-4 py-8 text-center text-sm text-gray-400">No groups of this type.</p>
                @endforelse
            </div>
        </x-card>

        {{-- Right main --}}
        <div x-data="editMode(false)" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'" class="space-y-6">
            @if ($selectedGroupId !== null)
                <x-card padding="p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Group Detail</h3>
                            <p class="mt-1 text-sm text-gray-500">Name, description, and activation window for the selected group.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <template x-if="!editing">
                                <button type="button" class="btn-primary" @click="enter()">Edit Record</button>
                            </template>
                            <template x-if="editing">
                                <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
                            </template>
                            <template x-if="editing">
                                <button type="button" class="btn-primary" @click="save()">Save</button>
                            </template>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="name" class="input-field" />
                            @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Group Type</label>
                            <select wire:model="group_type" class="input-field">
                                @foreach ($groupTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="description" rows="2" class="input-field"></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Active From</label>
                            <input type="date" wire:model="active_from" class="input-field" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Active To</label>
                            <input type="date" wire:model="active_to" class="input-field" />
                        </div>
                    </div>
                </x-card>

                <x-card padding="p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Members ({{ count($members) }})</h3>
                            <p class="mt-1 text-sm text-gray-500">Users assigned to this group.</p>
                        </div>
                    </div>

                    <div class="mt-4 overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                <tr>
                                    <th class="px-3 py-2">User Code</th>
                                    <th class="px-3 py-2">User Name</th>
                                    <th class="px-3 py-2">Department</th>
                                    <th class="px-3 py-2">From</th>
                                    <th class="px-3 py-2">To</th>
                                    <th class="px-3 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($members as $m)
                                    <tr>
                                        <td class="px-3 py-2 font-medium text-gray-900">{{ $m['user_code'] ?? '—' }}</td>
                                        <td class="px-3 py-2 text-gray-700">{{ $m['name'] }}</td>
                                        <td class="px-3 py-2 text-gray-600">{{ $m['department'] }}</td>
                                        <td class="px-3 py-2 text-gray-600">{{ $m['from'] ? \Carbon\Carbon::parse($m['from'])->format('d.m.y') : '—' }}</td>
                                        <td class="px-3 py-2 text-gray-600">{{ $m['to'] ? \Carbon\Carbon::parse($m['to'])->format('d.m.y') : '—' }}</td>
                                        <td class="px-3 py-2 text-right">
                                            <button type="button" wire:click="removeMember({{ $m['id'] }})" class="text-xs font-medium text-red-600 hover:text-red-800">Remove</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-3 py-8 text-center text-sm text-gray-400">No members.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 rounded-lg border border-dashed border-gray-300 p-4">
                        <p class="text-sm font-medium text-gray-700">Add a member</p>
                        <input
                            type="text"
                            wire:model.live.debounce.250ms="memberSearch"
                            placeholder="Search user code or name…"
                            class="input-field mt-2"
                        />
                        <div class="mt-3 space-y-1">
                            @forelse ($candidateUsers as $c)
                                <button type="button" wire:click="addMember({{ $c->id }})" class="flex w-full items-center justify-between rounded-md px-3 py-1.5 text-left text-sm hover:bg-blue-50">
                                    <span><span class="font-medium text-gray-900">{{ $c->user_code }}</span> <span class="text-gray-500">— {{ $c->name }}</span></span>
                                    <span class="text-xs font-medium text-blue-600">Add</span>
                                </button>
                            @empty
                                <p class="text-xs text-gray-400">
                                    {{ $memberSearch === '' ? 'Type a query to find users to add.' : 'No matching users.' }}
                                </p>
                            @endforelse
                        </div>
                    </div>
                </x-card>
            @else
                <x-card padding="p-12">
                    <p class="text-center text-sm text-gray-400">Select a group from the left rail — or click Create Group to add one.</p>
                </x-card>
            @endif
        </div>
    </div>
</div>
