<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-300">
        <div class="w-full max-w-md bg-white/90 rounded-2xl shadow-2xl p-10 flex flex-col items-center">
            <h2 class="mb-8 text-3xl font-extrabold text-blue-800 drop-shadow text-center tracking-wide">
                新規ユーザー登録
            </h2>
            <form class="w-full space-y-6" @submit.prevent="register">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-blue-700 font-semibold mb-1">ユーザー名</label>
                        <input
                            id="name"
                            v-model="name"
                            name="name"
                            type="text"
                            required
                            class="block w-full px-4 py-3 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg placeholder-blue-300 bg-blue-50 transition"
                            placeholder="ユーザー名"
                        />
                    </div>
                    <div>
                        <label for="email" class="block text-blue-700 font-semibold mb-1">メールアドレス</label>
                        <input
                            id="email"
                            v-model="email"
                            name="email"
                            type="email"
                            required
                            class="block w-full px-4 py-3 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg placeholder-blue-300 bg-blue-50 transition"
                            placeholder="メールアドレス"
                        />
                    </div>
                    <div>
                        <label for="password" class="block text-blue-700 font-semibold mb-1">パスワード</label>
                        <input
                            id="password"
                            v-model="password"
                            name="password"
                            type="password"
                            required
                            class="block w-full px-4 py-3 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg placeholder-blue-300 bg-blue-50 transition"
                            placeholder="パスワード"
                        />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-blue-700 font-semibold mb-1">パスワード（確認）</label>
                        <input
                            id="password_confirmation"
                            v-model="passwordConfirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="block w-full px-4 py-3 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg placeholder-blue-300 bg-blue-50 transition"
                            placeholder="パスワード（確認）"
                        />
                    </div>
                </div>
                <div>
                    <button
                        type="submit"
                        :disabled="isLoading"
                        class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 text-white text-lg font-bold shadow-md hover:from-blue-600 hover:to-blue-800 transition-all duration-200 disabled:opacity-60"
                    >
                        <span v-if="isLoading">登録中...</span>
                        <span v-else>新規登録</span>
                    </button>
                </div>
                <div v-if="error" class="text-red-600 text-sm text-center mt-2">
                    {{ error }}
                </div>
                <div v-if="success" class="text-green-600 text-sm text-center mt-2">
                    {{ success }}
                </div>
            </form>
            <router-link to="/login" class="mt-6 text-blue-600 hover:underline text-sm">ログイン画面へ</router-link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const error = ref('');
const success = ref('');
const isLoading = ref(false);

const register = async () => {
    error.value = '';
    success.value = '';
    isLoading.value = true;
    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                name: name.value,
                email: email.value,
                password: password.value,
                password_confirmation: passwordConfirmation.value
            })
        });
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.message || '登録に失敗しました');
        }
        success.value = '登録が完了しました。ログインしてください。';
        // 自動でログイン画面に遷移したい場合は下記を有効化
        // router.push('/login');
    } catch (e) {
        error.value = e instanceof Error ? e.message : '登録に失敗しました';
    } finally {
        isLoading.value = false;
    }
};
</script> 