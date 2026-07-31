@extends('layouts.guest')

@section('title', 'نسيت كلمة المرور')

@section('content')
    <h2 class="text-lg font-semibold mb-2">نسيت كلمة المرور؟</h2>
    <p class="text-sm text-slate-400 mb-6">هنبعتلك كود تحقق (OTP) على إيميلك، صالح لمدة 10 دقايق.</p>

    <form action="{{ route('password.request') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-slate-400 mb-1">الإيميل</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
        </div>
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 rounded-lg px-4 py-2 font-semibold">
            ابعت الكود
        </button>
    </form>

    <div class="text-center mt-6">
        <a href="{{ route('login') }}" class="text-sm text-sky-400 hover:text-sky-300">رجوع لتسجيل الدخول</a>
    </div>
@endsection
