<div class="space-y-6">
    <x-page-header title="User Management" description="Administer ATP 3.0 users, their profile data, and group memberships.">
        <x-slot name="actions">
            <a href="{{ route('system.user-management.create') }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                Create User
            </a>
        </x-slot>
    </x-page-header>

    <x-card padding="p-0">
        <div class="flex flex-wrap items-center gap-3 border-b border-gray-200 px-5 py-3">
            <div class="relative flex-1 min-w-[200px]">
                <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search user code, name, email, department…"
                    class="input-field pl-9"
                />
            </div>

            <select wire:model.live="statusFilter" class="input-field max-w-[160px]">
                <option value="all">All status</option>
                <option value="active">Active</option>
                <option value="locked">Locked</option>
                <option value="superuser">Superusers</option>
            </select>

            <select wire:model.live="branchFilter" class="input-field max-w-[160px]">
                <option value="all">All branches</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch }}">{{ $branch }}</option>
                @endforeach
            </select>

            <select wire:model.live="perPage" class="input-field max-w-[100px]">
                @foreach ([10, 25, 50, 100] as $n)
                    <option value="{{ $n }}">{{ $n }} / page</option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-4 py-3">User Code</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Branch</th>
                        <th class="px-4 py-3">Department</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Last Login</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-blue-50/40">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                <a href="{{ route('system.user-management.edit', ['id' => $user->id]) }}" class="text-blue-600 hover:underline">
                                    {{ $user->user_code ?? '—' }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->branch }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->department }}</td>
                            <td class="px-4 py-3">
                                @if ($user->is_superuser)
                                    <span class="inline-flex items-center rounded-full bg-purple-50 px-2.5 py-0.5 text-xs font-medium text-purple-700">Superuser</span>
                                @elseif ($user->is_locked)
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">Locked</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Active</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : '—' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('system.user-management.edit', ['id' => $user->id]) }}" class="text-xs font-medium text-blue-600 hover:text-blue-800">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-16 text-center text-sm text-gray-400">No users match the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t border-gray-200 px-5 py-3">
                {{ $users->links() }}
            </div>
        @endif
    </x-card>
</div>
