<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ニュース') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    ダッシュボードに戻る
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- 検索フォーム -->
            <div class="mb-6">
                <form action="{{ route('news.search') }}" method="GET" class="flex">
                    <input type="text" name="q" placeholder="ニュースを検索..." class="flex-1 rounded-l-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        検索
                    </button>
                </form>
            </div>

            <!-- カテゴリナビゲーション -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('news.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">トップニュース</a>
                <a href="{{ route('news.category', 'business') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">ビジネス</a>
                <a href="{{ route('news.category', 'entertainment') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">エンタメ</a>
                <a href="{{ route('news.category', 'health') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">健康</a>
                <a href="{{ route('news.category', 'science') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">科学</a>
                <a href="{{ route('news.category', 'sports') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">スポーツ</a>
                <a href="{{ route('news.category', 'technology') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">テクノロジー</a>
            </div>

            <!-- エラーメッセージ表示 -->
            @if($error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">エラー:</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endif

            <!-- ニュース記事一覧 -->
            <div class="space-y-6">
                @if(count($articles) > 0)
                    @foreach($articles as $article)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row">
                                    @if($article['urlToImage'])
                                        <div class="md:w-1/4 mb-4 md:mb-0 md:mr-6">
                                            <img src="{{ $article['urlToImage'] }}" alt="{{ $article['title'] }}" class="w-full h-auto rounded-md object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=No+Image';">
                                        </div>
                                    @endif
                                    <div class="md:w-3/4">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                            <a href="{{ $article['url'] }}" target="_blank" class="hover:text-blue-500 transition">
                                                {{ $article['title'] }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $article['description'] }}</p>
                                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $article['source']['name'] ?? '不明' }}</span>
                                            <span>{{ \Carbon\Carbon::parse($article['publishedAt'])->format('Y年m月d日 H:i') }}</span>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ $article['url'] }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                続きを読む
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <p class="text-gray-600 dark:text-gray-400">ニュース記事が見つかりませんでした。</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
