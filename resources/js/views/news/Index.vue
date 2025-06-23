<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- ヘッダー -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">ニュース</h1>
                <p class="text-gray-600">最新のニュースをお届けします</p>
            </div>

            <!-- 検索フォーム -->
            <div class="mb-6">
                <form @submit.prevent="searchNews" class="flex">
                    <input 
                        v-model="searchQuery" 
                        type="text" 
                        placeholder="ニュースを検索..." 
                        class="flex-1 rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-2"
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
                            : 'bg-white text-gray-800 hover:bg-blue-100 border border-gray-300'
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
            <div v-else class="space-y-8">
                <div v-if="articles.length > 0">
                    <div 
                        v-for="article in articles" 
                        :key="article.url"
                        class="bg-white overflow-hidden shadow-lg sm:rounded-xl hover:shadow-xl transition-all duration-300 border border-gray-100"
                    >
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row">
                                <div v-if="article.urlToImage" class="md:w-1/3 mb-6 md:mb-0 md:mr-8">
                                    <img 
                                        :src="article.urlToImage" 
                                        :alt="article.title" 
                                        class="w-full h-48 md:h-64 rounded-lg object-cover shadow-md"
                                        @error="article.urlToImage = 'https://via.placeholder.com/400x300?text=No+Image'"
                                    >
                                </div>
                                <div class="md:w-2/3">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">
                                        <a 
                                            :href="article.url" 
                                            target="_blank" 
                                            class="hover:text-blue-600 transition-colors duration-200"
                                        >
                                            {{ article.title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-6 text-lg leading-relaxed">{{ article.description }}</p>
                                    <div class="flex justify-between items-center text-sm text-gray-500 mb-6">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium">
                                            {{ article.source?.name || '不明' }}
                                        </span>
                                        <span class="text-gray-400">{{ formatDate(article.publishedAt) }}</span>
                                    </div>
                                    <div class="mt-6">
                                        <a 
                                            :href="article.url" 
                                            target="_blank" 
                                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg"
                                        >
                                            続きを読む
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                    <div class="p-12 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg">ニュース記事が見つかりませんでした。</p>
                        <p class="text-gray-400 mt-2">別のキーワードやカテゴリをお試しください。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

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

const fetchNews = async (endpoint = '/api/news') => {
    loading.value = true;
    error.value = null;
    try {
        const token = localStorage.getItem('token');
        const response = await fetch(endpoint, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });
        
        if (response.status === 401) {
            error.value = '認証されていません。ログインしてください。';
            articles.value = [];
            return;
        }
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        articles.value = data.articles || [];
    } catch (e: any) {
        error.value = e.message || 'ニュースの取得に失敗しました。';
        articles.value = [];
    } finally {
        loading.value = false;
    }
};

const fetchNewsByCategory = async (category: string) => {
    selectedCategory.value = category;
    if (category) {
        await fetchNews(`/api/news/category/${category}`);
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
        const token = localStorage.getItem('token');
        const response = await fetch(`/api/news/search?q=${encodeURIComponent(searchQuery.value)}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });
        
        if (response.status === 401) {
            error.value = '認証されていません。ログインしてください。';
            articles.value = [];
            return;
        }
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        articles.value = data.articles || [];
    } catch (e: any) {
        error.value = e.message || 'ニュースの検索に失敗しました。';
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

onMounted(() => {
    fetchNews();
});
</script> 