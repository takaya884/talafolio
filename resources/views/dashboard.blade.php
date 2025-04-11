<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ダッシュボード') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $menuItems = [
                    ['url' => '/memo', 'title' => 'メモ', 'description' => 'メモを作成・編集します', 'icon' => 'pencil'],
                    ['url' => '/news', 'title' => 'ニュース', 'description' => '最新のニュースを閲覧します', 'icon' => 'news'],
                    ['url' => '/session', 'title' => 'セッション', 'description' => 'セッション管理と学習', 'icon' => 'key'],
                    ['url' => '/send-email', 'title' => 'メール送信', 'description' => 'メールを送信します（予定）', 'icon' => 'mail'],
                    ['url' => '/chat', 'title' => 'チャット', 'description' => 'チャット機能を利用します（予定）', 'icon' => 'chat'],
                    ['url' => '/save', 'title' => '保存', 'description' => 'データを保存します', 'icon' => 'save'],
                    ['url' => '/video', 'title' => '動画再生', 'description' => '動画を再生します', 'icon' => 'play'],
                    ['url' => '/cron', 'title' => 'バッチ処理', 'description' => 'バッチ処理を実行します', 'icon' => 'play'],
                ];
                @endphp

                @foreach ($menuItems as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ $item['url'] }}" class="block p-6">
                            <div class="flex items-center">
                                <span class="text-blue-500 dark:text-blue-400">
                                    @if ($item['icon'] === 'pencil')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    @elseif ($item['icon'] === 'mail')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    @elseif ($item['icon'] === 'chat')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    @elseif ($item['icon'] === 'save')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                    @elseif ($item['icon'] === 'play')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif ($item['icon'] === 'news')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    @elseif ($item['icon'] === 'key')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    @endif
                                </span>
                                <span class="ml-3 text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $item['title'] }}</span>
                            </div>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $item['description'] }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>