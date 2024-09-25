<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('app_name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-100">
<div class="flex h-screen">
    {{-- メニューエリア --}}
    <div class="bg-white rounded-lg w-80 m-5 p-3 shadow-lg">
        <a href="/dashboard">
            <button class="block w-full bg-gray-500 text-white rounded font-bold text-xl mb-5" type="submit">ダッシュボードへ</button>
        </a>
        {{-- 新規作成ボタン --}}
        <form action="/" method="POST">
            @csrf
            <button class="block w-full bg-gray-500 text-white rounded font-bold text-xl mb-5" type="submit">+</button>
        </form>
        {{-- ノートブック --}}
        @foreach ($notes as $note)
        <div class="ml-3 mb-2">
            <h2 class="font-bold text-lg">{{ $note->note_title  }}</h2>
            <div class="flex flex-col ml-2">
                @foreach ($note->pages as $page)
                <a class="truncate" href="/">{{ $page->page_title }}</a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- テキストエリア --}}
    <div class="bg-white w-full rounded-lg my-5 mr-5 p-3 shadow-lg">
        <textarea class="w-full h-full p-3 resize-none outline-none" name="content" placeholder="Please input text content."></textarea>
    </div>
</div>
</body>
</html>
