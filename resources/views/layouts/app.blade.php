<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- 追記：laravel-viteで読み込まない代わりに、tailwindcssをCDNで読み込む -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- すべてのCSSを読み込む「public\css\color.css」 -->
        <link rel="stylesheet" href="css/color.css">
    </head>
    <!-- すべてのCSSを読み込む「public\css\color.css」を読み込む場所 -->
    <body class="font-sans antialiased background-color">
        {{-- <div class="min-h-screen bg-gray-100"> これがダメ--}}
        <div class="min-h-screen">
            <!-- ここで共通ヘッダーのコンポーネントを読み込み -->
            @include('layouts.announce-header') <!-- ログイン状態の読み込み -->
            @include('layouts.global-header')<!-- logo読み込み -->

            <!-- resources\views\dashboard.blade.phpの「$header」が読み込まれる -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- "dashだとあなたはログイン中ですよー！"が表示される箇所 -->
            <main class="container mx-auto py-8">
                {{ $slot }}
            </main>
        </div>
        <!-- 共通フッター表示 -->
        @include('layouts.footer')
    </body>
</html>
