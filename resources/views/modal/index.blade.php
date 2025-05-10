<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('モーダル学習') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">モーダルダイアログの学習</h3>
                    
                    <!-- ステータスメッセージ -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <p class="mb-2">モーダルダイアログとは、ユーザーの注意を特定のタスクに集中させるためのポップアップウィンドウです。</p>
                        <p class="mb-2">以下のボタンをクリックして、さまざまなタイプのモーダルを体験してみましょう。</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- 基本的なモーダル -->
                        <div class="border p-4 rounded-lg">
                            <h4 class="font-medium mb-2">基本的なモーダル</h4>
                            <p class="text-sm mb-3">シンプルな情報表示用モーダル</p>
                            <button type="button" onclick="openBasicModal()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                開く
                            </button>
                        </div>

                        <!-- フォーム付きモーダル -->
                        <div class="border p-4 rounded-lg">
                            <h4 class="font-medium mb-2">フォーム付きモーダル</h4>
                            <p class="text-sm mb-3">データ入力用のフォームを含むモーダル</p>
                            <button type="button" onclick="openFormModal()" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                                開く
                            </button>
                        </div>

                        <!-- 確認モーダル -->
                        <div class="border p-4 rounded-lg">
                            <h4 class="font-medium mb-2">確認モーダル</h4>
                            <p class="text-sm mb-3">ユーザーに確認を求めるモーダル</p>
                            <button type="button" onclick="openConfirmModal()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                開く
                            </button>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium mb-4">モーダルの実装方法</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="mb-2">モーダルの実装には主に以下の要素が必要です：</p>
                            <ul class="list-disc pl-5 mb-4">
                                <li>モーダルの表示/非表示を制御するJavaScript</li>
                                <li>モーダルのHTML構造（背景オーバーレイ、コンテンツ領域）</li>
                                <li>モーダルのスタイリング（CSS）</li>
                            </ul>
                            <p>このページでは、Alpine.jsを使用してモーダルを実装しています。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 基本的なモーダル -->
    <div id="basicModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 items-center justify-center z-50 hidden" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">基本的なモーダル</h3>
                    <button type="button" onclick="closeBasicModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        これは基本的なモーダルダイアログです。情報の表示や簡単なメッセージの伝達に使用されます。
                    </p>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeBasicModal()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                        閉じる
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- フォーム付きモーダル -->
    <div id="formModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 items-center justify-center z-50 hidden" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">お問い合わせフォーム</h3>
                    <button type="button" onclick="closeFormModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('modal.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">お名前</label>
                        <input type="text" name="name" id="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">メールアドレス</label>
                        <input type="email" name="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">メッセージ</label>
                        <textarea name="message" id="message" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeFormModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                            キャンセル
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                            送信
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 確認モーダル -->
    <div id="confirmModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 items-center justify-center z-50 hidden" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">確認</h3>
                    <button type="button" onclick="closeConfirmModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        この操作を実行してもよろしいですか？
                    </p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                        キャンセル
                    </button>
                    <button type="button" onclick="confirmAction()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                        実行する
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 基本的なモーダル
        function openBasicModal() {
            const modal = document.getElementById('basicModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.classList.add('overflow-hidden');
        }
        
        function closeBasicModal() {
            const modal = document.getElementById('basicModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.classList.remove('overflow-hidden');
        }
        
        // フォーム付きモーダル
        function openFormModal() {
            const modal = document.getElementById('formModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.classList.add('overflow-hidden');
        }
        
        function closeFormModal() {
            const modal = document.getElementById('formModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.classList.remove('overflow-hidden');
        }
        
        // 確認モーダル
        function openConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.classList.add('overflow-hidden');
        }
        
        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.classList.remove('overflow-hidden');
        }
        
        function confirmAction() {
            alert('アクションが確認されました！');
            closeConfirmModal();
        }
        
        // ESCキーでモーダルを閉じる
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeBasicModal();
                closeFormModal();
                closeConfirmModal();
            }
        });
        
        // モーダル外クリックで閉じる
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('basicModal')) {
                closeBasicModal();
            }
            if (event.target === document.getElementById('formModal')) {
                closeFormModal();
            }
            if (event.target === document.getElementById('confirmModal')) {
                closeConfirmModal();
            }
        });
    </script>
</x-app-layout>
