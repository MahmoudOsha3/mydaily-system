@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    <h2 class="text-xl md:text-2xl font-bold mb-6">أهلاً بيك 👋</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">نقاط النهاردة</p>
            <p class="text-2xl md:text-3xl font-bold text-emerald-400">{{ $todayPoints }} / {{ $todayMax }}</p>
        </div>
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">نقاط الشهر</p>
            <p class="text-2xl md:text-3xl font-bold text-sky-400">{{ $monthPoints }} / {{ $monthMax }}</p>
        </div>
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">رصيدك الحالي</p>
            <p class="text-2xl md:text-3xl font-bold {{ $balance >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($balance, 2) }} جنيه</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('tasks.today') }}" class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800 hover:border-emerald-600 transition">
            <p class="text-lg font-semibold mb-1">✅ تاسكات النهاردة</p>
            <p class="text-slate-400 text-sm">شوف وأنجز مهامك اليومية</p>
        </a>
        <a href="{{ route('finance.index') }}" class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800 hover:border-emerald-600 transition">
            <p class="text-lg font-semibold mb-1">💰 إدارة الفلوس</p>
            <p class="text-slate-400 text-sm">دخل: {{ number_format($totalIncome, 2) }} — مصروف: {{ number_format($totalExpense, 2) }}</p>
        </a>
    </div>
@endsection
