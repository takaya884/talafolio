<template>
    <div class="py-12 bg-gradient-to-br from-blue-100 to-blue-200 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h2 class="text-3xl font-bold mb-8 text-blue-800 drop-shadow">ダッシュボード</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- メモ機能 -->
                    <router-link
                        to="/memo"
                        class="block p-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-white"
                    >
                        <h3 class="text-xl font-semibold mb-2">メモ</h3>
                        <p class="text-blue-100">メモの作成・管理ができます</p>
                    </router-link>
                    <!-- ニュース機能 -->
                    <router-link
                        to="/news"
                        class="block p-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-white"
                    >
                        <h3 class="text-xl font-semibold mb-2">ニュース</h3>
                        <p class="text-blue-100">最新のニュースを確認できます</p>
                    </router-link>
                    <!-- セッション機能 -->
                    <router-link
                        to="/session"
                        class="block p-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-white"
                    >
                        <h3 class="text-xl font-semibold mb-2">セッション</h3>
                        <p class="text-blue-100">セッションの管理ができます</p>
                    </router-link>
                    <!-- メール機能 -->
                    <router-link
                        to="/email"
                        class="block p-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-white"
                    >
                        <h3 class="text-xl font-semibold mb-2">メール</h3>
                        <p class="text-blue-100">メールの送信ができます</p>
                    </router-link>
                    <!-- Cron機能 -->
                    <router-link
                        to="/cron"
                        class="block p-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-white"
                    >
                        <h3 class="text-xl font-semibold mb-2">Cron</h3>
                        <p class="text-blue-100">Cronジョブの管理ができます</p>
                    </router-link>
                    <!-- 新規ユーザー作成 -->
                    <router-link
                        to="/register"
                        class="block p-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-white"
                    >
                        <h3 class="text-xl font-semibold mb-2">新規ユーザー作成</h3>
                        <p class="text-blue-100">新しいユーザーを登録できます</p>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

onMounted(() => {
    // 認証チェック
    const token = localStorage.getItem('token');
    if (!token) {
        router.push('/login');
    }
});
</script> 