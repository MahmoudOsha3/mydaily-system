@extends('layouts.app')

@section('title', 'الإحصائيات')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-lg md:text-2xl font-bold">📊 إحصائيات شهر {{ $month->translatedFormat('F Y') }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('stats.index', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" class="bg-slate-800 rounded-lg px-3 py-2 text-sm">◀ الشهر اللي فات</a>
            <a href="{{ route('stats.index', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" class="bg-slate-800 rounded-lg px-3 py-2 text-sm">الشهر الجاي ▶</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">إجمالي النقاط</p>
            <p class="text-2xl md:text-3xl font-bold text-emerald-400">{{ $totalPointsMonth }} / {{ $totalMaxMonth }}</p>
        </div>
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">نسبة الإنجاز</p>
            <p class="text-2xl md:text-3xl font-bold text-sky-400">{{ $totalMaxMonth > 0 ? round($totalPointsMonth / $totalMaxMonth * 100) : 0 }}%</p>
        </div>
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">أفضل يوم</p>
            <p class="text-2xl md:text-3xl font-bold text-amber-400">{{ $bestDay['day'] ?? '-' }} ({{ $bestDay['points'] ?? 0 }} نقطة)</p>
        </div>
    </div>

    <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
        @foreach ($days as $day)
            <div class="bg-slate-900 border border-slate-800 rounded-lg p-2 md:p-3 text-center">
                <p class="text-xs text-slate-400 mb-1">{{ $day['day'] }}</p>
                <p class="font-bold text-sm md:text-base {{ $day['points'] == $day['max_points'] && $day['max_points'] > 0 ? 'text-emerald-400' : 'text-slate-300' }}">
                    {{ $day['points'] }}
                </p>
                <p class="text-[10px] text-slate-500">{{ $day['done_count'] }}/{{ $day['total_count'] }}</p>
            </div>
        @endforeach
    </div>
@endsection
