<div>
    <x-page-header title="Authorizations" description="Assign module-level Full / Read Only / No Authorization to users or groups." />

    <div class="mt-6 grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
        {{-- Left rail: Users / Groups tabs + list --}}
        <x-card padding="p-0">
            <div class="flex border-b border-gray-200">
                <button type="button"
                    wire:click="switchTab('users')"
                    class="flex-1 border-b-2 px-4 py-3 text-sm font-medium transition {{ $subjectTab === 'users' ? 'border-[#2f5bff] text-[#2f5bff]' : 'border-transparent text-gray-500 hover:text-[#2f5bff]' }}">
                    Users
                </button>
                <button type="button"
                    wire:click="switchTab('groups')"
                    class="flex-1 border-b-2 px-4 py-3 text-sm font-medium transition {{ $subjectTab === 'groups' ? 'border-[#2f5bff] text-[#2f5bff]' : 'border-transparent text-gray-500 hover:text-[#2f5bff]' }}">
                    Groups
                </button>
            </div>

            <div class="border-b border-gray-200 p-3">
                <input type="text"
                    wire:model.live.debounce.250ms="find"
                    placeholder="Filter…"
                    class="input-field"
                />
            </div>

            <div class="max-h-[70vh] overflow-y-auto">
                @forelse ($subjectList as $s)
                    <button type="button"
                        wire:click="selectSubject({{ $s['id'] }})"
                        class="flex w-full items-center justify-between border-b border-gray-100 px-4 py-2.5 text-left text-sm transition hover:bg-blue-50 {{ $subjectId === $s['id'] ? 'bg-blue-50 font-semibold text-blue-700' : 'text-gray-700' }}">
                        <span class="truncate">{{ $s['label'] }}</span>
                        @if ($subjectId === $s['id'])
                            <x-icon name="chevron-right" class="h-4 w-4 text-blue-500 shrink-0" />
                        @endif
                    </button>
                @empty
                    <p class="px-4 py-8 text-center text-sm text-gray-400">No {{ $subjectTab }}.</p>
                @endforelse
            </div>
        </x-card>

        {{-- Right main: tree + action buttons --}}
        <x-card padding="p-0">
            @if ($subjectId === null)
                <p class="p-12 text-center text-sm text-gray-400">Select a {{ $subjectTab === 'users' ? 'user' : 'group' }} from the left to view its authorizations.</p>
            @else
                <div class="flex items-center justify-between gap-4 border-b border-gray-200 px-5 py-3">
                    <p class="text-sm text-gray-600">
                        Click a subject row to select it, then use the action buttons below to set its authorization level. Level changes cascade to descendants.
                    </p>
                </div>

                <div class="overflow-hidden">
                    <div class="flex items-center justify-between bg-gray-50 px-5 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <span>Subject</span>
                        <span>Authorization</span>
                    </div>

                    <ul class="max-h-[60vh] overflow-y-auto">
                        @foreach ($roots as $root)
                            @include('livewire.admin._permission-tree-node', [
                                'permission' => $root,
                                'depth' => 0,
                                'levels' => $levels,
                                'selectedPermissionId' => $selectedPermissionId,
                            ])
                        @endforeach
                    </ul>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-2 border-t border-gray-200 px-5 py-3">
                    <span class="mr-auto text-xs text-gray-500">
                        @if ($selectedPermissionId)
                            Selected: Permission #{{ $selectedPermissionId }} (actions apply to it and all descendants)
                        @else
                            Select a permission row first
                        @endif
                    </span>
                    <button type="button"
                        wire:click="setLevel('full')"
                        @disabled(!$selectedPermissionId)
                        class="btn-primary disabled:opacity-50">Full Authorization</button>
                    <button type="button"
                        wire:click="setLevel('read_only')"
                        @disabled(!$selectedPermissionId)
                        class="btn-secondary disabled:opacity-50">Read Only</button>
                    <button type="button"
                        wire:click="setLevel('none')"
                        @disabled(!$selectedPermissionId)
                        class="btn-secondary disabled:opacity-50">No Authorization</button>
                </div>
            @endif
        </x-card>
    </div>
</div>
