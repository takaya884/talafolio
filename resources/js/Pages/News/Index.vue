<template>
    <Head title="ニュース" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    ニュース
                </h2>
                <div class="flex space-x-2">
                    <Link :href="route('dashboard')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ダッシュボードに戻る
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- 検索フォーム -->
                <div class="mb-6">
                    <form @submit.prevent="searchNews" class="flex">
                        <input 
                            v-model="searchQuery" 
                            type="text" 
                            placeholder="ニュースを検索..." 
                            class="flex-1 rounded-l-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                        >
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            検索
                        </button>
                    </form>
                </div>

                <!-- カテゴリナビゲーション -->
                <div class="mb-6 flex flex-wrap gap-2">
                    <button 
                        v-for="category in categories" 
                        :key="category.value"
                        @click="fetchNewsByCategory(category.value)"
                        :class="[
                            'px-4 py-2 rounded-md transition',
                            selectedCategory === category.value 
                                ? 'bg-blue-600 text-white' 
                                : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800'
                        ]"
                    >
                        {{ category.label }}
                    </button>
                </div>

                <!-- エラーメッセージ表示 -->
                <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">エラー:</strong>
                    <span class="block sm:inline">{{ error }}</span>
                </div>

                <!-- ローディング表示 -->
                <div v-if="loading" class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                </div>

                <!-- ニュース記事一覧 -->
                <div v-else class="space-y-6">
                    <div v-if="articles.length > 0">
                        <div 
                            v-for="article in articles" 
                            :key="article.url"
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300"
                        >
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row">
                                    <div v-if="article.urlToImage" class="md:w-1/4 mb-4 md:mb-0 md:mr-6">
                                        <img 
                                            :src="article.urlToImage" 
                                            :alt="article.title" 
                                            class="w-full h-auto rounded-md object-cover"
                                            @error="article.urlToImage = 'https://via.placeholder.com/300x200?text=No+Image'"
                                        >
                                    </div>
                                    <div class="md:w-3/4">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                            <a 
                                                :href="article.url" 
                                                target="_blank" 
                                                class="hover:text-blue-600 transition"
                                            >
                                                {{ article.title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ article.description }}</p>
                                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ article.source?.name || '不明' }}</span>
                                            <span>{{ formatDate(article.publishedAt) }}</span>
                                        </div>
                                        <div class="mt-4">
                                            <a 
                                                :href="article.url" 
                                                target="_blank" 
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                            >
                                                続きを読む
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <p class="text-gray-600 dark:text-gray-400">ニュース記事が見つかりませんでした。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

interface Article {
    url: string;
    urlToImage?: string;
    title: string;
    description?: string;
    source?: { name?: string };
    publishedAt?: string;
}

const articles = ref<Article[]>([]);
const error = ref<string|null>(null);
const loading = ref(false);
const searchQuery = ref('');
const selectedCategory = ref('');

const categories = [
    { value: '', label: 'トップニュース' },
    { value: 'business', label: 'ビジネス' },
    { value: 'entertainment', label: 'エンタメ' },
    { value: 'health', label: '健康' },
    { value: 'science', label: '科学' },
    { value: 'sports', label: 'スポーツ' },
    { value: 'technology', label: 'テクノロジー' }
];

const fetchNews = async (endpoint = '/news') => {
    loading.value = true;
    error.value = null;
    try {
        const response = await axios.get(endpoint, { withCredentials: true });
        if (response.status === 401) {
            error.value = '認証されていません。ログインしてください。';
            articles.value = [];
            return;
        }
        articles.value = response.data.articles || [];
    } catch (e: any) {
        if (e.response && e.response.status === 401) {
            error.value = '認証されていません。ログインしてください。';
        } else {
            error.value = e.response?.data?.message || 'ニュースの取得に失敗しました。';
        }
        articles.value = [];
    } finally {
        loading.value = false;
    }
};

const fetchNewsByCategory = async (category: string) => {
    selectedCategory.value = category;
    if (category) {
        await fetchNews(`/news/category/${category}`);
    } else {
        await fetchNews();
    }
};

const searchNews = async () => {
    if (!searchQuery.value.trim()) {
        await fetchNews();
        return;
    }
    loading.value = true;
    error.value = null;
    try {
        const response = await axios.get(`/news/search`, {
            params: { q: searchQuery.value },
            withCredentials: true
        });
        if (response.status === 401) {
            error.value = '認証されていません。ログインしてください。';
            articles.value = [];
            return;
        }
        articles.value = response.data.articles || [];
    } catch (e: any) {
        if (e.response && e.response.status === 401) {
            error.value = '認証されていません。ログインしてください。';
        } else {
            error.value = e.response?.data?.message || 'ニュースの検索に失敗しました。';
        }
        articles.value = [];
    } finally {
        loading.value = false;
    }
};

const formatDate = (dateString?: string) => {
    if (!dateString) return '日付不明';
    const date = new Date(dateString);
    return date.toLocaleDateString('ja-JP', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const router = useRouter();
const goDashboard = () => {
    router.push('/dashboard');
};

onMounted(() => {
    fetchNews();
});
</script> 