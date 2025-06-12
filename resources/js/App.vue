<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
        <nav v-if="isAuthenticated" class="bg-gradient-to-r from-blue-700 to-blue-500 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <router-link to="/dashboard" class="text-2xl font-bold text-white tracking-wide drop-shadow-lg">
                                Talafolio
                            </router-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <router-link
                                v-for="item in navigationItems"
                                :key="item.path"
                                :to="item.path"
                                class="inline-flex items-center px-3 pt-1 border-b-2 transition-all duration-200"
                                :class="[
                                    $route.path === item.path
                                        ? 'border-white text-white font-semibold'
                                        : 'border-transparent text-blue-100 hover:text-white hover:border-blue-200'
                                ]"
                            >
                                {{ item.name }}
                            </router-link>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button
                            @click="logout"
                            class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-100 shadow transition-all duration-200"
                        >
                            ログアウト
                        </button>
                        <span v-if="userName" class="ml-4 text-white font-bold text-lg drop-shadow">{{ userName }}</span>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const userName = ref('');

const isAuthenticated = computed(() => {
    return !!localStorage.getItem('token');
});

onMounted(async () => {
    if (isAuthenticated.value) {
        try {
            const res = await fetch('/api/user', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json',
                },
            });
            if (res.ok) {
                const data = await res.json();
                userName.value = data.name;
            }
        } catch (e) {}
    }
});

const navigationItems = [
    { name: 'ダッシュボード', path: '/dashboard' },
    { name: 'メモ', path: '/memo' },
    { name: 'ニュース', path: '/news' },
    { name: 'セッション', path: '/session' },
    { name: 'メール', path: '/email' },
    { name: 'Cron', path: '/cron' }
];

const logout = async () => {
    try {
        await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });
        localStorage.removeItem('token');
        router.push('/login');
    } catch (error) {
        console.error('ログアウトに失敗しました:', error);
    }
};
</script> 