@extends('layouts.app')

@section('title', 'تاسكات اليوم')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
        <h2 class="text-lg md:text-2xl font-bold">تاسكات يوم {{ $date->translatedFormat('l، d F Y') }}</h2>
        <div class="text-emerald-400 font-bold text-lg md:text-xl">{{ $totalPoints }} / {{ $maxPoints }} نقطة</div>
    </div>

    <div class="w-full bg-slate-800 rounded-full h-3 mb-8">
        <div class="bg-emerald-500 h-3 rounded-full transition-all" style="width: {{ $maxPoints > 0 ? round($totalPoints / $maxPoints * 100) : 0 }}%"></div>
    </div>

    <div class="space-y-3 mb-8">
        @forelse ($tasks as $task)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-900 border border-slate-800 rounded-xl p-4 {{ $task->status === 'done' ? 'opacity-60' : '' }}">
                <div class="flex items-center gap-4">
                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $task->status === 'done' ? 'pending' : 'done' }}">
                        <button type="submit" class="w-7 h-7 shrink-0 rounded-full border-2 {{ $task->status === 'done' ? 'bg-emerald-500 border-emerald-500' : 'border-slate-600' }} flex items-center justify-center">
                            @if ($task->status === 'done')
                                <span class="text-slate-950 text-sm">✓</span>
                            @endif
                        </button>
                    </form>
                    <div>
                        <p class="font-semibold {{ $task->status === 'done' ? 'line-through' : '' }}">{{ $task->title }}</p>
                        @if ($task->start_time)
                            <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($task->start_time)->format('h:i A') }}
                                @if ($task->end_time) - {{ \Carbon\Carbon::parse($task->end_time)->format('h:i A') }} @endif
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-3">
                    <span class="text-sm text-slate-400">{{ $task->points }} نقطة</span>
                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="skipped">
                        <button type="submit" class="text-slate-500 hover:text-amber-400 text-sm">تخطي</button>
                    </form>
                    @if (is_null($task->task_template_id))
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-400 text-sm">حذف</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-slate-400">مفيش تاسكات، ضيف واحدة تحت 👇</p>
        @endforelse
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 md:p-6">
        <h3 class="font-semibold mb-4">➕ إضافة تاسك للنهاردة</h3>
        <form action="{{ route('tasks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            @csrf
            <input type="hidden" name="date" value="{{ $date->toDateString() }}">
            <input type="text" name="title" placeholder="اسم التاسك" required class="md:col-span-2 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <input type="number" name="points" placeholder="النقاط" value="5" min="0" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 rounded-lg px-4 py-2 font-semibold">إضافة</button>
        </form>
    </div>
@endsection
