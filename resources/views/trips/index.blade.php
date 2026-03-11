@extends('layouts.app')

@section('title', 'Trip Logs – Lalamove Driver Portal')
@section('containerClass', 'max-w-5xl')

@section('content')

{{-- ── Summary ─────────────────────────────────────────────────────────── --}}
<div class="mb-8">
    <h2 class="text-orange-500 text-xs font-bold tracking-widest uppercase mb-4">Summary</h2>

    {{--
        Mobile  : Total Earnings spans 2 cols (full width),
                  Net Profit and Completed each take 1 col.
        Desktop : All 3 cards in 3 equal columns.
    --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        {{-- Total Earnings --}}
        <div class="col-span-2 md:col-span-1 bg-[#1d1008] rounded-2xl border border-orange-900/20 p-5">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-orange-500/70" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z"/>
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z" clip-rule="evenodd"/>
                    <path d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z"/>
                </svg>
                <span class="text-orange-100/50 text-sm">Total Earnings</span>
            </div>
            <p class="text-white text-2xl md:text-3xl font-extrabold tracking-tight">
                RM {{ number_format($summary['total_earnings'], 2) }}
            </p>
        </div>

        {{-- Net Profit --}}
        <div class="bg-[#1d1008] rounded-2xl border border-orange-900/20 p-5">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-orange-500/70" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75-6.75a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/>
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/>
                </svg>
                <span class="text-orange-500/80 text-sm">Net Profit</span>
            </div>
            <p class="text-orange-500 text-2xl md:text-3xl font-extrabold tracking-tight">
                RM {{ number_format($summary['net_profit'], 2) }}
            </p>
        </div>

        {{-- Completed Trips --}}
        <div class="bg-[#1d1008] rounded-2xl border border-orange-900/20 p-5">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-orange-500/70" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-2.099 3.468-4.698 3.468-7.827C19.75 7.255 16.242 4 12 4S4.25 7.255 4.25 11.5c0 3.129 1.524 5.728 3.469 7.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.144.742ZM12 13.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" clip-rule="evenodd"/>
                </svg>
                <span class="text-orange-500/80 text-sm md:text-orange-100/50 md:text-sm">Completed</span>
            </div>
            <p class="text-white text-2xl md:text-3xl font-extrabold tracking-tight">
                {{ $summary['completed'] }}
                <span class="text-orange-100/40 text-base font-semibold md:hidden"> Trips</span>
                <span class="hidden md:inline text-orange-100/40 text-base font-semibold"> Trips</span>
            </p>
        </div>

    </div>
</div>

{{-- ── Recent Trips ─────────────────────────────────────────────────────── --}}
<div>

    {{-- Section header --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-orange-500 text-xs font-bold tracking-widest uppercase">Recent Trips</h2>
        <a href="#"
           class="flex items-center gap-1.5 text-orange-400 hover:text-orange-300 text-xs font-semibold transition-colors">
            Export CSV
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
        </a>
    </div>

    {{-- Trip cards --}}
    <div class="space-y-3">
        @foreach ($trips as $trip)
        <div class="relative bg-[#1d1008] rounded-2xl border border-orange-900/20 p-4 md:p-5">

            {{-- Delete button --}}
            <button type="button"
                    class="absolute -top-3 -right-3 w-7 h-7 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center shadow-lg transition-colors z-10"
                    aria-label="Delete trip">
                <svg class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- ── Desktop top row: badge + date ──────────────────────── --}}
            <div class="hidden md:flex items-center gap-3 mb-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-500/15 text-green-400 border border-green-500/30 uppercase tracking-wider">
                    {{ $trip['status'] }}
                </span>
                <span class="text-orange-100/40 text-xs">{{ $trip['date'] }} &bull; {{ $trip['time'] }}</span>
            </div>

            {{-- ── Desktop: order heading ─────────────────────────────── --}}
            <p class="hidden md:block text-white font-bold mb-3 pr-6">Order #{{ $trip['order_id'] }}</p>

            {{-- ── Mobile top row: badge + order ID ──────────────────── --}}
            <div class="flex md:hidden items-center justify-between mb-3 pr-6">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-500/15 text-green-400 border border-green-500/30 uppercase tracking-wider">
                    {{ $trip['status'] }}
                </span>
                <span class="text-orange-100/40 text-xs font-medium">#{{ $trip['order_id'] }}</span>
            </div>

            {{-- ── Route  +  Fare columns ──────────────────────────────── --}}
            <div class="flex items-start justify-between gap-4">

                {{-- Route with dot-line-dot indicator --}}
                <div class="flex items-start gap-3 min-w-0 flex-1">
                    {{-- Dot → line → dot --}}
                    <div class="flex flex-col items-center flex-shrink-0 mt-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500 block flex-shrink-0"></span>
                        <span class="w-px bg-orange-900/40 flex-1 my-1" style="min-height: 1.75rem; display: block;"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500 block flex-shrink-0"></span>
                    </div>
                    {{-- Location names --}}
                    <div class="min-w-0 flex-1">
                        <p class="text-white text-sm font-medium leading-tight truncate">{{ $trip['pickup'] }}</p>
                        <div class="h-5"></div>
                        <p class="text-white text-sm font-medium leading-tight truncate">{{ $trip['dropoff'] }}</p>
                    </div>
                </div>

                {{-- Fare --}}
                <div class="text-right flex-shrink-0">
                    <p class="text-orange-100/40 text-[10px] font-semibold uppercase tracking-widest leading-none mb-1">Gross Fare</p>
                    <p class="text-white text-sm font-semibold">RM {{ number_format($trip['gross_fare'], 2) }}</p>
                    <p class="text-orange-100/40 text-[10px] font-semibold uppercase tracking-widest leading-none mt-2 mb-1">Net Profit</p>
                    <p class="text-orange-500 text-lg md:text-xl font-extrabold leading-tight">RM {{ number_format($trip['net_profit'], 2) }}</p>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- Load More --}}
    <div class="mt-6 flex justify-center">
        <button type="button"
                class="w-full md:w-auto px-8 py-4 rounded-xl border border-orange-600/60 text-orange-400 hover:text-orange-300 hover:border-orange-500 font-bold text-sm uppercase tracking-widest transition-colors bg-transparent">
            Load More Trips
        </button>
    </div>

</div>

@endsection
