<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('クッキー') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">クッキーとは</h3>
                    <div class="mb-6 space-y-4">
                        <p>クッキー（Cookie）は、Webサイトがブラウザを通じてユーザーのコンピュータに保存する小さなテキストファイルです。これにより、Webサイトはユーザーの設定や状態を記憶することができます。</p>
                        
                        <h4 class="text-md font-semibold mt-4">クッキーの主な用途</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>ログイン状態の維持</li>
                            <li>ユーザー設定の保存</li>
                            <li>ショッピングカートの内容の記憶</li>
                            <li>アクセス解析</li>
                            <li>広告のパーソナライズ</li>
                        </ul>

                        <h4 class="text-md font-semibold mt-4">クッキーの種類</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li><strong>セッションクッキー：</strong>ブラウザを閉じると削除される一時的なクッキー</li>
                            <li><strong>永続クッキー：</strong>設定された期間、ユーザーのデバイスに保存されるクッキー</li>
                            <li><strong>ファーストパーティクッキー：</strong>訪問しているサイトによって設定されるクッキー</li>
                            <li><strong>サードパーティクッキー：</strong>訪問しているサイト以外（広告主など）によって設定されるクッキー</li>
                        </ul>

                        <h4 class="text-md font-semibold mt-4">Laravelでのクッキーの扱い方</h4>
                        <p>Laravelでは、クッキーを簡単に設定、取得、削除することができます。</p>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md mt-2">
                            <pre class="text-sm">
// クッキーの設定
$response = response('Hello World');
$response->cookie('name', 'value', $minutes);

// クッキーの取得
$value = $request->cookie('name');

// クッキーの削除
$response->cookie('name', '', -1);
                            </pre>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 mt-8">クッキーのデモ</h3>
                    <div class="mb-6">
                        <p class="mb-4">現在のクッキー状態：</p>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                            @if(isset($_COOKIE['sample_cookie']))
                                <p>sample_cookie: {{ $_COOKIE['sample_cookie'] }}</p>
                            @else
                                <p>クッキーは設定されていません</p>
                            @endif
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <form method="POST" action="{{ route('cookie.set') }}">
                                @csrf
                                <x-primary-button>
                                    {{ __('クッキーを設定') }}
                                </x-primary-button>
                            </form>

                            <form method="POST" action="{{ route('cookie.remove') }}">
                                @csrf
                                <x-secondary-button>
                                    {{ __('クッキーを削除') }}
                                </x-secondary-button>
                            </form>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 mt-8">プライバシーとセキュリティ</h3>
                    <div class="space-y-4">
                        <p>クッキーはユーザー体験を向上させる一方で、プライバシーに関する懸念も存在します。</p>
                        
                        <h4 class="text-md font-semibold">注意点</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>機密情報（パスワードなど）をクッキーに保存しないこと</li>
                            <li>必要に応じてクッキーを暗号化すること</li>
                            <li>ユーザーにクッキーの使用について通知すること</li>
                            <li>GDPR（EU一般データ保護規則）などの法規制に準拠すること</li>
                        </ul>
                        
                        <h4 class="text-md font-semibold mt-4">Laravelでのセキュアなクッキー</h4>
                        <p>Laravelでは、デフォルトで暗号化されたクッキーを使用できます。</p>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md mt-2">
                            <pre class="text-sm">
// config/session.phpで設定
'encrypt' => true,

// 暗号化されたクッキーの使用
Cookie::queue('name', 'value', $minutes);
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
