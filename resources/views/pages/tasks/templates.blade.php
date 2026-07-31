@extends('layouts.app')

@section('title', 'التاسكات الثابتة')

@section('content')
    <h2 class="text-lg md:text-2xl font-bold mb-6">🔁 التاسكات الثابتة (الروتين اليومي)</h2>

    <div class="space-y-3 mb-8">
        @foreach ($templates as $template)
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-4">
                <form action="{{ route('templates.update', $template) }}" method="POST" class="grid grid-cols-2 md:grid-cols-6 gap-3 items-center">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="title" value="{{ $template->title }}" class="col-span-2 md:col-span-2 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
                    <input type="time" name="start_time" value="{{ $template->start_time }}" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
                    <input type="time" name="end_time" value="{{ $template->end_time }}" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
                    <input type="number" name="points" value="{{ $template->points }}" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
                    <div class="flex items-center gap-2 col-span-2 md:col-span-1">
                        <label class="flex items-center gap-1 text-sm">
                            <input type="checkbox" name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }}>
                            فعّال
                        </label>
                        <button type="submit" class="bg-sky-700 hover:bg-sky-600 rounded-lg px-3 py-1 text-sm">حفظ</button>
                    </div>
                </form>
                <form action="{{ route('templates.destroy', $template) }}" method="POST" onsubmit="return confirm('حذف التاسك الثابت {{ $template->title }}؟')" class="mt-2 text-left">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-rose-500 hover:text-rose-400 text-xs">حذف التاسك ده</button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 md:p-6">
        <h3 class="font-semibold mb-4">➕ إضافة تاسك ثابت جديد</h3>
        <form action="{{ route('templates.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-3">
            @csrf
            <input type="text" name="title" placeholder="اسم التاسك" required class="md:col-span-2 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <input type="time" name="start_time" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <input type="time" name="end_time" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <input type="number" name="points" placeholder="النقاط" value="5" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 rounded-lg px-4 py-2 font-semibold">إضافة</button>
        </form>
    </div>
@endsection
