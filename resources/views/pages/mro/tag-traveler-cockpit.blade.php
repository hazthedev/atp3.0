@extends('layouts.app')

@section('title', 'Tag Traveler Cockpit')

@section('content')
    <div
        class="space-y-6"
        x-data="{
            barcode: '',
            statusMessage: '',
            closeScan() {
                this.statusMessage = this.barcode
                    ? `Scan session closed for barcode ${this.barcode}.`
                    : 'Tag traveler scan window closed.';
            },
        }"
    >
        <x-page-header
            title="Tag Traveler Cockpit"
            description="Scan a tag traveler barcode to continue with MRO execution and traveler tracking."
        />

        <section class="attach-workspace-shell max-w-[1160px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="flex min-h-[420px] flex-col justify-between">
                <div class="space-y-6">
                    <div class="pt-2">
                        <h2 class="text-3xl font-semibold tracking-tight text-gray-900">Scan a Barcode :</h2>
                        <p class="mt-1 text-sm text-gray-500">Use a scanner or paste the traveler barcode to continue into the selected work context.</p>
                    </div>

                    <div class="max-w-[420px]">
                        <input
                            type="text"
                            x-model="barcode"
                            class="input-field attach-input"
                            placeholder="Scan or enter barcode"
                            autofocus
                        />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" class="btn-secondary" @click="closeScan()">Close</button>
                </div>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
