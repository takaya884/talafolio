<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $note->note_title }}
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

                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <a href="{{ route('memo.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-300 ease-in-out mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                戻る
                            </a>
                            <h3 class="text-xl font-bold">{{ $note->note_title }}</h3>
                        </div>
                        <button id="addPageBtn" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-300 ease-in-out flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            ページを追加
                        </button>
                    </div>

                    <!-- ページ一覧 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($note->pages as $page)
                            <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="font-bold text-lg">{{ $page->page_title }}</h4>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('memo.edit', $page->id) }}" class="text-blue-500 hover:text-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('memo.destroy', $page->id) }}" method="POST" class="inline" onsubmit="return confirm('このページを削除してもよろしいですか？');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                        最終更新: {{ $page->updated_at ? $page->updated_at->format('Y/m/d H:i') : '日時不明' }}
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg whitespace-pre-wrap">
                                        {{ $page->page_contents }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ページ追加モーダル -->
                    <div id="addPageModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold">新しいページを追加</h3>
                                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('memo.add-page', $note->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="page_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ページタイトル</label>
                                    <input type="text" name="page_title" id="page_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" placeholder="ページのタイトルを入力" required>
                                </div>
                                <div class="mb-4">
                                    <label for="page_contents" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">内容</label>
                                    <textarea name="page_contents" id="page_contents" rows="6" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" placeholder="メモの内容を入力してください" required></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300 ease-in-out">
                                        追加
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const addPageBtn = document.getElementById('addPageBtn');
                            const addPageModal = document.getElementById('addPageModal');
                            const closeModal = document.getElementById('closeModal');

                            addPageBtn.addEventListener('click', function() {
                                addPageModal.classList.remove('hidden');
                                addPageModal.classList.add('flex');
                            });

                            closeModal.addEventListener('click', function() {
                                addPageModal.classList.add('hidden');
                                addPageModal.classList.remove('flex');
                            });

                            // モーダルの外側をクリックしたときに閉じる
                            addPageModal.addEventListener('click', function(e) {
                                if (e.target === addPageModal) {
                                    addPageModal.classList.add('hidden');
                                    addPageModal.classList.remove('flex');
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
