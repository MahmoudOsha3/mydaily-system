<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نظام اليوميات')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar: desktop/tablet only --}}
        <aside class="w-60 shrink-0 bg-slate-900 border-l border-slate-800 p-6 hidden md:block">
            <h1 class="text-xl font-bold text-emerald-400 mb-8">📅 يومياتي</h1>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-emerald-400' : '' }}">🏠 الرئيسية</a>
                <a href="{{ route('tasks.today') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('tasks.today') ? 'bg-slate-800 text-emerald-400' : '' }}">✅ تاسكات اليوم</a>
                <a href="{{ route('templates.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('templates.index') ? 'bg-slate-800 text-emerald-400' : '' }}">🔁 التاسكات الثابتة</a>
                <a href="{{ route('stats.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('stats.index') ? 'bg-slate-800 text-emerald-400' : '' }}">📊 الإحصائيات</a>
                <a href="{{ route('finance.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('finance.index') ? 'bg-slate-800 text-emerald-400' : '' }}">💰 إدارة الفلوس</a>
            </nav>

            <form action="{{ route('logout') }}" method="POST" class="mt-10">
                @csrf
                <button type="submit" class="w-full text-right px-4 py-2 rounded-lg text-rose-400 hover:bg-slate-800 text-sm">🚪 تسجيل الخروج</button>
            </form>
        </aside>

        {{-- Mobile top bar --}}
        <div class="md:hidden fixed top-0 inset-x-0 bg-slate-900 border-b border-slate-800 z-10 px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-bold text-emerald-400">📅 يومياتي</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-rose-400 text-sm">🚪 خروج</button>
            </form>
        </div>

        <main class="flex-1 w-full min-w-0 p-4 pt-20 md:pt-8 md:p-8 pb-24 md:pb-8">
            @if (session('success'))
                <div class="mb-6 bg-emerald-900/40 border border-emerald-700 text-emerald-300 px-4 py-3 rounded-lg text-sm md:text-base">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Mobile bottom nav --}}
    <nav class="md:hidden fixed bottom-0 inset-x-0 bg-slate-900 border-t border-slate-800 flex justify-around py-2 z-10">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-slate-400' }}">
            <span class="text-lg">🏠</span>الرئيسية
        </a>
        <a href="{{ route('tasks.today') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('tasks.today') ? 'text-emerald-400' : 'text-slate-400' }}">
            <span class="text-lg">✅</span>اليوم
        </a>
        <a href="{{ route('templates.index') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('templates.index') ? 'text-emerald-400' : 'text-slate-400' }}">
            <span class="text-lg">🔁</span>الروتين
        </a>
        <a href="{{ route('stats.index') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('stats.index') ? 'text-emerald-400' : 'text-slate-400' }}">
            <span class="text-lg">📊</span>إحصائيات
        </a>
        <a href="{{ route('finance.index') }}" class="flex flex-col items-center text-xs {{ request()->routeIs('finance.index') ? 'text-emerald-400' : 'text-slate-400' }}">
            <span class="text-lg">💰</span>فلوس
        </a>
    </nav>
</body>
</html>
