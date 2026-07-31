@extends('layouts.app')

@section('title', 'إدارة الفلوس')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-lg md:text-2xl font-bold">💰 إدارة الفلوس - {{ $month->translatedFormat('F Y') }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('finance.index', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" class="bg-slate-800 rounded-lg px-3 py-2 text-sm">◀</a>
            <a href="{{ route('finance.index', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" class="bg-slate-800 rounded-lg px-3 py-2 text-sm">▶</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">إجمالي الدخل</p>
            <p class="text-xl md:text-2xl font-bold text-emerald-400">{{ number_format($totalIncome, 2) }} جنيه</p>
        </div>
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">إجمالي المصروفات</p>
            <p class="text-xl md:text-2xl font-bold text-rose-400">{{ number_format($totalExpense, 2) }} جنيه</p>
        </div>
        <div class="bg-slate-900 rounded-xl p-5 md:p-6 border border-slate-800">
            <p class="text-slate-400 text-sm mb-2">الرصيد</p>
            <p class="text-xl md:text-2xl font-bold {{ $balance >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($balance, 2) }} جنيه</p>
        </div>
    </div>

    @if ($expensesByCategory->count())
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 md:p-6 mb-8">
            <h3 class="font-semibold mb-4">المصروفات حسب النوع</h3>
            <div class="space-y-2">
                @foreach ($expensesByCategory as $category => $amount)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-300">{{ $category }}</span>
                        <span class="text-rose-400">{{ number_format($amount, 2) }} جنيه</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 md:p-6 mb-8">
        <h3 class="font-semibold mb-4">➕ إضافة حركة مالية</h3>
        <form action="{{ route('finance.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-3">
            @csrf
            <select name="type" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
                <option value="income">دخل</option>
                <option value="expense">مصروف</option>
            </select>
            <input type="number" step="0.01" name="amount" placeholder="المبلغ" required class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <input type="text" name="category" placeholder="النوع (أكل، مواصلات...)" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <input type="text" name="description" placeholder="ملاحظة" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <input type="date" name="date" value="{{ now()->toDateString() }}" required class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <button type="submit" class="md:col-span-5 bg-emerald-600 hover:bg-emerald-500 rounded-lg px-4 py-2 font-semibold">إضافة</button>
        </form>
    </div>

    <div class="space-y-2">
        @forelse ($transactions as $t)
            <div class="flex items-center justify-between bg-slate-900 border border-slate-800 rounded-xl p-4">
                <div>
                    <p class="font-semibold {{ $t->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                        {{ $t->type === 'income' ? '+' : '-' }}{{ number_format($t->amount, 2) }} جنيه
                    </p>
                    <p class="text-xs text-slate-400">{{ $t->category ?? 'بدون تصنيف' }} — {{ $t->date->translatedFormat('d F') }} @if($t->description) — {{ $t->description }} @endif</p>
                </div>
                <form action="{{ route('finance.destroy', $t) }}" method="POST" onsubmit="return confirm('حذف الحركة؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-rose-500 hover:text-rose-400 text-sm">حذف</button>
                </form>
            </div>
        @empty
            <p class="text-slate-400">مفيش حركات مسجلة الشهر ده</p>
        @endforelse
    </div>
@endsection
