<x-app-layout>
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
        <div class="bg-white rounded-lg w-80 m-5 p-3 shadow-lg overflow-y-auto">
            <a href="/dashboard" class="mb-5 block">
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white rounded font-bold text-xl py-2 transition duration-300 ease-in-out" type="submit">ダッシュボードへ</button>
            </a>
            {{-- 新規作成ボタン --}}
            <form action="/" method="POST" class="mb-5">
                @csrf
                <button class="w-full bg-green-500 hover:bg-green-600 text-white rounded font-bold text-xl py-2 transition duration-300 ease-in-out" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    新規作成
                </button>
            </form>
            {{-- ノートブック --}}
            @foreach ($notes as $note)
            <div class="ml-3 mb-4 bg-gray-100 p-3 rounded-lg">
                <h2 class="font-bold text-lg text-gray-800 mb-2">{{ $note->note_title }}</h2>
                <div class="flex flex-col ml-2 space-y-1">
                    @foreach ($note->pages as $page)
                    <a class="truncate text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out" href="/">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        {{ $page->page_title }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        {{-- テキストエリア --}}
        <div class="bg-white w-full rounded-lg my-5 mr-5 p-3 shadow-lg flex flex-col">
            <textarea class="w-full h-full p-3 resize-none outline-none border rounded-lg focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" name="content" placeholder="ここにテキストを入力してください。"></textarea>
        </div>
    </div>
    </body>
    </html>
</x-app-layout>