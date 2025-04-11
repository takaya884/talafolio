<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('セッション管理') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- セッション情報 -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">セッション基本情報</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-4">
                            <p><span class="font-medium">セッションID:</span> {{ $sessionId }}</p>
                            <p><span class="font-medium">セッション有効期限:</span> {{ $sessionLifetime }} 分</p>
                        </div>
                        
                        <div class="flex space-x-4 mt-4">
                            <form action="{{ route('session.regenerate') }}" method="POST">
                                @csrf
                                <x-primary-button>
                                    セッションID再生成
                                </x-primary-button>
                            </form>
                            
                            <form action="{{ route('session.clear') }}" method="POST">
                                @csrf
                                <x-danger-button>
                                    セッションクリア
                                </x-danger-button>
                            </form>
                        </div>
                    </div>

                    <!-- セッション解説 -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">セッションとは？</h3>
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <p class="mb-2">セッションとは、ウェブアプリケーションにおいて一時的にユーザーデータを保存する仕組みです。</p>
                            <p class="mb-2">Laravelでは、セッションデータは以下の方法で保存できます：</p>
                            <ul class="list-disc list-inside ml-4 mb-2">
                                <li>ファイル（デフォルト）</li>
                                <li>データベース</li>
                                <li>Redis</li>
                                <li>Memcached</li>
                                <li>Cookie</li>
                            </ul>
                            <p class="mb-2">セッションIDはユーザーのブラウザにCookieとして保存され、サーバー側のセッションデータと紐づけられます。</p>
                            <p>セッションはユーザー認証、フォームデータの一時保存、買い物かごなど様々な用途に使用されます。</p>
                        </div>
                    </div>

                    <!-- セッションデータ追加フォーム -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">セッションデータ追加</h3>
                        <form action="{{ route('session.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="key" :value="__('キー')" />
                                    <x-text-input id="key" name="key" type="text" class="mt-1 block w-full" required />
                                </div>
                                <div>
                                    <x-input-label for="value" :value="__('値')" />
                                    <x-text-input id="value" name="value" type="text" class="mt-1 block w-full" required />
                                </div>
                            </div>
                            <x-primary-button>
                                セッションに追加
                            </x-primary-button>
                        </form>
                    </div>

                    <!-- セッションデータ一覧 -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">セッションデータ一覧</h3>
                        
                        @if (count($sessionData) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 dark:bg-gray-600">
                                        <tr>
                                            <th class="py-2 px-4 text-left">キー</th>
                                            <th class="py-2 px-4 text-left">値</th>
                                            <th class="py-2 px-4 text-left">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sessionData as $key => $value)
                                            @if (!is_array($value) && !is_object($value))
                                                <tr class="border-b border-gray-200 dark:border-gray-600">
                                                    <td class="py-2 px-4">{{ $key }}</td>
                                                    <td class="py-2 px-4">
                                                        @if (strlen($value) > 100)
                                                            {{ substr($value, 0, 100) }}...
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                    <td class="py-2 px-4">
                                                        @if (!in_array($key, ['_token', '_previous', '_flash']))
                                                            <form action="{{ route('session.destroy', $key) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <x-danger-button type="submit" class="py-1 px-2 text-xs">
                                                                    削除
                                                                </x-danger-button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="border-b border-gray-200 dark:border-gray-600">
                                                    <td class="py-2 px-4">{{ $key }}</td>
                                                    <td class="py-2 px-4">[複合データ]</td>
                                                    <td class="py-2 px-4">-</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>セッションデータがありません</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- セッションの仕組み解説 -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">セッションの仕組み</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium mb-2">セッションの流れ</h4>
                            <ol class="list-decimal list-inside ml-4">
                                <li class="mb-1">ユーザーが初めてサイトにアクセス</li>
                                <li class="mb-1">サーバーがセッションIDを生成</li>
                                <li class="mb-1">セッションIDをCookieとしてブラウザに送信</li>
                                <li class="mb-1">ブラウザが次回リクエスト時にCookieを送信</li>
                                <li class="mb-1">サーバーがCookieからセッションIDを取得</li>
                                <li>セッションIDに紐づくデータを取得・更新</li>
                            </ol>
                        </div>
                        
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium mb-2">セッションのセキュリティ</h4>
                            <ul class="list-disc list-inside ml-4">
                                <li class="mb-1">セッションハイジャック対策：定期的なセッションID再生成</li>
                                <li class="mb-1">HTTPS使用によるセッションCookieの保護</li>
                                <li class="mb-1">適切なセッション有効期限の設定</li>
                                <li class="mb-1">セッションデータの暗号化</li>
                                <li>ログアウト時のセッション破棄</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-4 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-medium mb-2">Laravelでのセッション操作</h4>
                        <div class="bg-gray-200 dark:bg-gray-600 p-3 rounded">
                            <pre class="text-sm overflow-x-auto">
// セッションに値を保存
$request->session()->put('key', 'value');

// セッションから値を取得
$value = $request->session()->get('key');

// セッションから値を削除
$request->session()->forget('key');

// すべてのセッションデータを削除
$request->session()->flush();

// セッションIDを再生成
$request->session()->regenerate();
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
