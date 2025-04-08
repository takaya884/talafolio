<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('メモ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex h-screen">
                        {{-- メニューエリア --}}
                        <div class="dark:bg-gray-700 rounded-lg w-80 p-3 shadow-lg overflow-y-auto mr-4">
                            <a href="/dashboard" class="mb-5 block">
                                <button class="w-full bg-blue-500 hover:bg-blue-600 text-black rounded font-bold text-xl py-2 transition duration-300 ease-in-out" type="submit">ダッシュボードへ</button>
                            </a>
                            {{-- 新規作成ボタン --}}
                            <a href="{{ route('memo.create') }}" class="mb-5 block">
                                <button class="w-full bg-green-500 hover:bg-green-600 text-black rounded font-bold text-xl py-2 transition duration-300 ease-in-out flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    新規作成
                                </button>
                            </a>
                            {{-- ノートブック --}}
                            @if($notes->isEmpty())
                                <p class="text-gray-500 dark:text-gray-400 text-center py-4">メモがありません</p>
                            @else
                                @foreach($notes as $note)
                                <div class="ml-3 mb-4 bg-gray-100 dark:bg-gray-600 p-3 rounded-lg">
                                    <h2 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-2">{{ $note->note_title }}</h2>
                                    <div class="flex flex-col ml-2 space-y-1">
                                        @foreach($note->pages as $page)
                                        <a class="truncate text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition duration-300 ease-in-out" href="{{ route('memo.edit', $page->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            {{ $page->page_title }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- テキストエリア --}}
                        <div class="bg-white dark:bg-gray-800 w-full rounded-lg p-3 shadow-lg flex flex-col">
                            <div class="p-4 text-center text-gray-600 dark:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-xl font-bold mb-2">メモを選択してください</h3>
                                <p>左側のメニューからメモを選択するか、新規作成ボタンで新しいメモを作成してください。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>