<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('app_name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-blue-100">
<div class="flex h-screen">
    {{-- メニューエリア --}}
    <div class="bg-white rounded-lg w-80 m-5 p-3 shadow-lg">
        {{-- 新規作成ボタン --}}
        <form action="/" method="POST">
            @csrf
            <button class="block w-full bg-gray-500 text-white rounded font-bold text-xl mb-5" type="submit">+</button>
        </form>
        {{-- ノートブック１ --}}
        <div class="ml-3 mb-2">
            <h2 class="font-bold text-lg">Work</h2>
            <div class="flex flex-col ml-2">
                <a class="truncate" href="/">Note1</a>
                <a class="truncate" href="/">Note2</a>
            </div>
        </div>
        {{-- ノートブック２ --}}
        <div class="ml-3 mb-2">
            <h2 class="font-bold text-lg">Private</h2>
            <div class="flex flex-col ml-2">
                <a class="truncate" href="/">Note1</a>
                <a class="truncate" href="/">Note2</a>
                <a class="truncate" href="/">Note3</a>
            </div>
        </div>
        {{-- ノートブック３ --}}
        <div class="ml-3 mb-2">
            <h2 class="font-bold text-lg">Family</h2>
            <div class="flex flex-col ml-2">
                <a class="truncate" href="/">Note1</a>
            </div>
        </div>
    </div>

    {{-- テキストエリア --}}
    <div class="bg-white w-full rounded-lg my-5 mr-5 p-3 shadow-lg">
        <textarea class="w-full h-full p-3 resize-none outline-none" name="content" placeholder="Please input text content."></textarea>
    </div>
</div>
</body>
</html>
