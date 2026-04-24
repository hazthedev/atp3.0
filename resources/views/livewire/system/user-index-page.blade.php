<div class="space-y-6">
    <x-page-header title="User Management" description="Administer ATP 3.0 users, their profile data, and group memberships.">
        <x-slot name="actions">
            <a href="{{ route('system.user-management.create') }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                Create User
            </a>
        </x-slot>
    </x-page-header>

    <p class="text-sm text-gray-500">
        Browse {{ $users->count() }} users with client-side search, sorting, and pagination.
    </p>

    <x-data-table
        :empty="$users->count() === 0"
        empty-label="No users found"
        empty-description="Create a new user to get started."
        search-meta=""
        datatable
    >
        <x-slot name="thead">
            <tr>
                <th class="table-th">User Code</th>
                <th class="table-th">Name</th>
                <th class="table-th">Email</th>
                <th class="table-th">Branch</th>
                <th class="table-th">Department</th>
                <th class="table-th">Status</th>
                <th class="table-th">Last Login</th>
                <th class="table-th" data-sortable="false">Actions</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($users as $user)
                <tr class="table-row">
                    <td class="table-td">
                        <a href="{{ route('system.user-management.edit', ['id' => $user->id]) }}" class="font-medium text-blue-600 hover:underline">
                            {{ $user->user_code ?? '—' }}
                        </a>
                    </td>
                    <td class="table-td">{{ $user->name }}</td>
                    <td class="table-td">{{ $user->email }}</td>
                    <td class="table-td">{{ $user->branch }}</td>
                    <td class="table-td">{{ $user->department }}</td>
                    <td class="table-td">
                        @if ($user->is_superuser)
                            <span class="inline-flex items-center rounded-full bg-purple-50 px-2.5 py-0.5 text-xs font-medium text-purple-700">Superuser</span>
                        @elseif ($user->is_locked)
                            <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">Locked</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Active</span>
                        @endif
                    </td>
                    <td class="table-td">{{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : '—' }}</td>
                    <td class="table-td">
                        <div class="flex gap-2">
                            <a href="{{ route('system.user-management.edit', ['id' => $user->id]) }}" class="btn-ghost px-3">View</a>
                            <a href="{{ route('system.user-management.edit', ['id' => $user->id]) }}" class="btn-secondary px-3">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
