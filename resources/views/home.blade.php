@extends('layouts.app')

@section('content')

{{-- ── Page Header ─────────────────────────────────────────────────────── --}}
<div class="mb-6">
    <div class="flex items-center gap-2 mb-3">
        <svg class="w-4 h-4 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
        </svg>
        <span class="text-orange-500 text-xs font-bold tracking-widest uppercase">Manual Entry</span>
    </div>
    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 leading-tight">Record New Trip</h1>
    <p class="text-orange-100/40 text-sm leading-relaxed max-w-sm">Enter your trip details accurately. This information is used to calculate your weekly earnings, fuel efficiency, and performance bonuses.</p>
</div>

{{-- ── Main Form Card ───────────────────────────────────────────────────── --}}
<div class="bg-[#1d1008] rounded-2xl border border-orange-900/20 overflow-hidden">
    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        {{-- ── Section 1: Time & Order Details ─────────────────────────── --}}
        <div class="p-5 md:p-6 space-y-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/>
                </svg>
                <h2 class="text-white font-semibold">Time & Order Details</h2>
            </div>

            {{-- Trip Date & Trip Time --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Trip Date</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <svg class="w-4 h-4 text-orange-500/60 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        <input type="date" name="trip_date" value="{{ now()->format('Y-m-d') }}"
                               class="bg-transparent flex-1 py-3 pl-2 text-white text-sm focus:outline-none [color-scheme:dark]">
                    </div>
                    <p class="text-orange-400/40 text-xs">Auto-filled based on current date</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Trip Time</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <svg class="w-4 h-4 text-orange-500/60 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <input type="time" name="trip_time" value="{{ now()->format('H:i') }}"
                               class="bg-transparent flex-1 py-3 pl-2 text-white text-sm focus:outline-none [color-scheme:dark]">
                    </div>
                    <p class="text-orange-400/40 text-xs">Auto-filled based on current time</p>
                </div>

            </div>

            {{-- Lalamove Order ID --}}
            <div class="space-y-1.5">
                <label class="block text-orange-100/70 text-sm font-medium">Lalamove Order ID</label>
                <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                    <span class="text-orange-500 font-bold text-base pr-2.5 border-r border-orange-900/40">#</span>
                    <input type="text" name="order_id" placeholder="e.g. MY-12345678"
                           class="bg-transparent flex-1 py-3 pl-2.5 text-white text-sm placeholder-orange-200/20 focus:outline-none">
                </div>
                <p class="text-orange-400/40 text-xs">Found in your Lalamove app order history</p>
            </div>
        </div>

        <div class="h-px bg-orange-900/20 mx-5 md:mx-6"></div>

        {{-- ── Section 2: Route Information ──────────────────────────────── --}}
        <div class="p-5 md:p-6 space-y-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-2.099 3.468-4.698 3.468-7.827C19.75 7.255 16.242 4 12 4S4.25 7.255 4.25 11.5c0 3.129 1.524 5.728 3.469 7.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.144.742ZM12 13.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" clip-rule="evenodd"/>
                </svg>
                <h2 class="text-white font-semibold">Route Information</h2>
            </div>

            {{-- Pickup Area & Drop-off Area --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Pickup Area</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <input type="text" name="pickup_area" placeholder="e.g. Bangsar South"
                               class="bg-transparent flex-1 py-3 text-white text-sm placeholder-orange-200/20 focus:outline-none">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Drop-off Area</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <input type="text" name="dropoff_area" placeholder="e.g. Mont Kiara"
                               class="bg-transparent flex-1 py-3 text-white text-sm placeholder-orange-200/20 focus:outline-none">
                    </div>
                </div>

            </div>

            {{-- Distance to Pickup & Delivery Distance --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Distance to Pickup (km)</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <input type="number" name="distance_to_pickup" value="0.0" step="0.1" min="0"
                               class="bg-transparent flex-1 py-3 text-white text-sm focus:outline-none">
                        <span class="text-orange-400/60 text-sm font-medium">km</span>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Delivery Distance (km)</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <input type="number" name="delivery_distance" value="0.0" step="0.1" min="0"
                               class="bg-transparent flex-1 py-3 text-white text-sm focus:outline-none">
                        <span class="text-orange-400/60 text-sm font-medium">km</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="h-px bg-orange-900/20 mx-5 md:mx-6"></div>

        {{-- ── Section 3: Earnings & Expenses ──────────────────────────── --}}
        <div class="p-5 md:p-6 space-y-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z"/>
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z" clip-rule="evenodd"/>
                    <path d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z"/>
                </svg>
                <h2 class="text-white font-semibold">Earnings & Expenses</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Gross Fare --}}
                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Gross Fare (RM)</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <span class="text-orange-400/70 text-sm font-medium pr-2.5 border-r border-orange-900/40">RM</span>
                        <input type="number" name="gross_fare" value="0.00" step="0.01" min="0"
                               class="bg-transparent flex-1 py-3 pl-2.5 text-white text-sm focus:outline-none">
                    </div>
                    <p class="text-orange-400/40 text-xs">The total amount shown in the app before commissions</p>
                </div>

                {{-- Tolls / Parking --}}
                <div class="space-y-1.5">
                    <label class="block text-orange-100/70 text-sm font-medium">Tolls / Parking (RM)</label>
                    <div class="flex items-center bg-[#271609] border border-[#3d2010] rounded-xl px-3 focus-within:border-orange-500/70 focus-within:ring-1 focus-within:ring-orange-500/30 transition-all">
                        <span class="text-orange-400/70 text-sm font-medium pr-2.5 border-r border-orange-900/40">RM</span>
                        <input type="number" name="tolls_parking" value="0.00" step="0.01" min="0"
                               class="bg-transparent flex-1 py-3 pl-2.5 text-white text-sm focus:outline-none">
                    </div>
                    <p class="text-orange-400/40 text-xs">Keep receipts for verification</p>
                </div>

            </div>
        </div>

        {{-- ── Submit Button ─────────────────────────────────────────────── --}}
        <div class="px-5 md:px-6 pb-5 md:pb-6">
            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-400 active:bg-orange-600 text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2.5 transition-colors uppercase tracking-widest text-sm shadow-lg shadow-orange-900/30">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z"/>
                </svg>
                Submit Trip
            </button>
        </div>

    </form>
</div>

@endsection