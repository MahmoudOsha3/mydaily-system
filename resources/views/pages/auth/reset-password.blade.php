@extends('layouts.guest')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
    <h2 class="text-lg font-semibold mb-2">إعادة تعيين كلمة المرور</h2>
    <p class="text-sm text-slate-400 mb-6">دخّل الكود اللي وصلك على الإيميل مع كلمة المرور الجديدة.</p>

    <form action="{{ route('password.reset') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label class="block text-sm text-slate-400 mb-1">الإيميل</label>
            <input type="email" value="{{ $email }}" disabled
                   class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-3 py-2 text-slate-400">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">كود التحقق (OTP)</label>
            <input type="text" name="otp" inputmode="numeric" maxlength="6" required autofocus
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 tracking-[0.5em] text-center">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">كلمة المرور الجديدة</label>
            <input type="password" name="password" required minlength="6"
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" required minlength="6"
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
        </div>
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 rounded-lg px-4 py-2 font-semibold">
            غيّر كلمة المرور
        </button>
    </form>

    <div class="text-center mt-6">
        <a href="{{ route('password.request.form') }}" class="text-sm text-sky-400 hover:text-sky-300">اطلب كود جديد</a>
    </div>
@endsection
