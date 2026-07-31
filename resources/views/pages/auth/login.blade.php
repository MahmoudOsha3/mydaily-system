@extends('layouts.guest')

@section('title', 'تسجيل الدخول')

@section('content')
    <h2 class="text-lg font-semibold mb-6">تسجيل الدخول</h2>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-slate-400 mb-1">الإيميل</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">كلمة المرور</label>
            <input type="password" name="password" required
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-400">
            <input type="checkbox" name="remember">
            فاكرني
        </label>
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 rounded-lg px-4 py-2 font-semibold">
            دخول
        </button>
    </form>

    <div class="text-center mt-6">
        <a href="{{ route('password.request.form') }}" class="text-sm text-sky-400 hover:text-sky-300">نسيت كلمة المرور؟</a>
    </div>
@endsection
