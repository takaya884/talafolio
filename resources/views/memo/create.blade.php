<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('新規メモ作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('memo.store') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="note_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">メモタイトル</label>
                            <input type="text" name="note_title" id="note_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" placeholder="メモのタイトルを入力" value="{{ old('note_title') }}" required>
                            @error('note_title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="page_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ページタイトル</label>
                            <input type="text" name="page_title" id="page_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" placeholder="ページのタイトルを入力" value="{{ old('page_title') }}" required>
                            @error('page_title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="page_contents" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">内容</label>
                            <textarea name="page_contents" id="page_contents" rows="10" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" placeholder="メモの内容を入力してください" required>{{ old('page_contents') }}</textarea>
                            @error('page_contents')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('memo.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-300 ease-in-out">
                                キャンセル
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-300 ease-in-out">
                                保存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
