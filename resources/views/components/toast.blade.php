@once
    <style>
        @keyframes toast-shrink {
            from { width: 100%; }
            to { width: 0; }
        }
    </style>
@endonce

<div
    class="pointer-events-none fixed right-4 top-4 z-50 space-y-3"
    x-data="{
        toasts: [],
        add(toast) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, title: toast.title || 'Status update', ...toast });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) {
            this.toasts = this.toasts.filter((toast) => toast.id !== id);
        },
        tone(type) {
            return {
                success: 'bg-emerald-100 text-emerald-600',
                error: 'bg-red-100 text-red-600',
                warning: 'bg-amber-100 text-amber-600',
                info: 'bg-blue-100 text-blue-600',
            }[type] || 'bg-blue-100 text-blue-600';
        },
    }"
    @toast.window="add($event.detail)"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            class="pointer-events-auto relative min-w-[320px] overflow-hidden rounded-xl border border-gray-200 bg-white p-4 shadow-lg"
            x-show="true"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="translate-x-4 opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-4 opacity-0"
        >
            <div class="flex items-start gap-3">
                <div class="rounded-lg p-2" :class="tone(toast.type)">
                    <x-icon name="check-circle" class="h-5 w-5" x-show="toast.type === 'success'" />
                    <x-icon name="x-circle" class="h-5 w-5" x-show="toast.type === 'error'" />
                    <x-icon name="exclamation-triangle" class="h-5 w-5" x-show="toast.type === 'warning'" />
                    <x-icon name="information-circle" class="h-5 w-5" x-show="! toast.type || toast.type === 'info'" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900" x-text="toast.title"></p>
                    <p class="mt-1 text-sm text-gray-500" x-text="toast.message"></p>
                </div>
                <button type="button" class="rounded-md p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700" @click="remove(toast.id)" aria-label="Dismiss toast">
                    <x-icon name="x-circle" class="h-4 w-4" />
                </button>
            </div>
            <div class="absolute bottom-0 left-0 h-1 rounded-full bg-blue-600" style="animation: toast-shrink 5s linear forwards;"></div>
        </div>
    </template>
</div>
