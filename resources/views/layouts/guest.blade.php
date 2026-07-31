<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'تسجيل الدخول')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-bold text-emerald-400 text-center mb-8">📅 يومياتي</h1>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8">
            @if (session('success'))
                <div class="mb-5 bg-emerald-900/40 border border-emerald-700 text-emerald-300 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 bg-rose-900/40 border border-rose-700 text-rose-300 px-4 py-3 rounded-lg text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
