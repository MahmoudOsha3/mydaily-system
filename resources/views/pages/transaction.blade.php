@extends('layouts.app')
@section('title', 'المصاريف والدخل')

@section('content')
    @php
        $prevMonth = $month->copy()->subMonth()->format('Y-m');
        $nextMonth = $month->copy()->addMonth()->format('Y-m');
        $categories = ['أكل', 'مواصلات', 'فواتير', 'تسوق', 'صحة', 'ترفيه', 'مرتب', 'فريلانس', 'تانى'];
    @endphp

    <div x-data="{ showModal: false, type: 'expense' }">

        {{-- header --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('transactions.index', ['month' => $prevMonth]) }}"
                   class="w-9 h-9 flex items-center justify-center rounded-lg stub text-muted hover:text-slate-100">‹</a>
                <h1 class="text-xl font-extrabold text-slate-100 font-mono">{{ $month->translatedFormat('F Y') }}</h1>
                <a href="{{ route('transactions.index', ['month' => $nextMonth]) }}"
                   class="w-9 h-9 flex items-center justify-center rounded-lg stub text-muted hover:text-slate-100">›</a>
            </div>

            <button @click="showModal = true"
                    class="text-sm font-semibold bg-gold text-ink px-4 py-2 rounded-lg hover:opacity-90 transition">
                + حركة جديدة
            </button>
        </div>

        {{-- summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="stub rounded-xl p-5">
                <p class="text-xs text-muted mb-2">الرصيد</p>
                <p class="font-mono text-2xl font-bold {{ $balance >= 0 ? 'text-gold' : 'text-coral' }}">{{ number_format($balance, 2) }}</p>
            </div>
            <div class="stub rounded-xl p-5">
                <p class="text-xs text-muted mb-2">دخل الشهر</p>
                <p class="font-mono text-2xl font-bold text-teal">+{{ number_format($totalIncome, 2) }}</p>
            </div>
            <div class="stub rounded-xl p-5">
                <p class="text-xs text-muted mb-2">مصروف الشهر</p>
                <p class="font-mono text-2xl font-bold text-coral">-{{ number_format($totalExpense, 2) }}</p>
            </div>
        </div>

        {{-- list --}}
        <div class="space-y-2.5">
            @forelse($transactions as $tx)
                <div class="stub rounded-xl px-4 py-3.5 flex items-center gap-4">
                    <div class="w-16 shrink-0 font-mono text-xs text-muted text-center">
                        {{ \Illuminate\Support\Carbon::parse($tx->date)->format('d M') }}
                    </div>

                    <div class="w-px self-stretch bg-line shrink-0"></div>

                    <span class="w-2 h-2 rounded-full shrink-0 {{ $tx->type === 'income' ? 'bg-teal' : 'bg-coral' }}"></span>

                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-100 truncate">{{ $tx->category ?: ($tx->type === 'income' ? 'دخل' : 'مصروف') }}</p>
                        @if($tx->description)
                            <p class="text-xs text-muted truncate mt-0.5">{{ $tx->description }}</p>
                        @endif
                    </div>

                    <span class="font-mono text-sm font-semibold shrink-0 {{ $tx->type === 'income' ? 'text-teal' : 'text-coral' }}">
                        {{ $tx->type === 'income' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                    </span>

                    <form action="{{ route('transactions.destroy', $tx) }}" method="POST" onsubmit="return confirm('تحذف الحركة دي؟')">
                        @csrf @method('DELETE')
                        <button class="w-8 h-8 rounded-lg text-muted hover:text-coral hover:bg-coral/10 transition flex items-center justify-center text-sm">🗑</button>
                    </form>
                </div>
            @empty
                <div class="stub rounded-xl px-4 py-10 text-center text-muted text-sm">
                    مفيش حركات الشهر دة لسه.
                </div>
            @endforelse
        </div>

        {{-- add transaction modal --}}
        <div x-show="showModal" x-cloak style="display:none"
             class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div @click.outside="showModal = false"
                 class="bg-ink-2 border border-line rounded-2xl p-6 w-full max-w-md">
                <h2 class="font-bold text-lg text-slate-100 mb-4">حركة مالية جديدة</h2>

                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-3">
                    @csrf

                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" x-model="type" class="peer hidden">
                            <div class="text-center py-2 rounded-lg border border-line text-sm text-muted peer-checked:bg-teal/15 peer-checked:text-teal peer-checked:border-teal/40 transition">دخل</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" x-model="type" class="peer hidden">
                            <div class="text-center py-2 rounded-lg border border-line text-sm text-muted peer-checked:bg-coral/15 peer-checked:text-coral peer-checked:border-coral/40 transition">مصروف</div>
                        </label>
                    </div>

                    <div>
                        <label class="text-xs text-muted block mb-1">المبلغ</label>
                        <input type="number" step="0.01" name="amount" required
                               class="w-full bg-ink-3 border border-line rounded-lg px-3 py-2 text-sm text-slate-100 font-mono focus:outline-none focus:ring-2 focus:ring-gold/40">
                    </div>

                    <div>
                        <label class="text-xs text-muted block mb-1">التصنيف</label>
                        <select name="category"
                                class="w-full bg-ink-3 border border-line rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-gold/40">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-muted block mb-1">ملاحظة (اختياري)</label>
                        <input type="text" name="description"
                               class="w-full bg-ink-3 border border-line rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-gold/40">
                    </div>

                    <div>
                        <label class="text-xs text-muted block mb-1">التاريخ</label>
                        <input type="date" name="date" value="{{ now()->toDateString() }}" required
                               class="w-full bg-ink-3 border border-line rounded-lg px-3 py-2 text-sm text-slate-100 font-mono focus:outline-none focus:ring-2 focus:ring-gold/40">
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="button" @click="showModal = false"
                                class="flex-1 py-2 rounded-lg text-sm text-muted hover:text-slate-100 transition">إلغاء</button>
                        <button type="submit"
                                class="flex-1 py-2 rounded-lg text-sm font-semibold bg-gold text-ink hover:opacity-90 transition">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
