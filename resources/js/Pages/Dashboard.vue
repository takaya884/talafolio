<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in! Vue-Dashboard</div>
                </div>
            </div>
        </div>

        <!-- <dashboard-button :to="{ name: 'user.index' }">ユーザーマスタ</dashboard-button> -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <button @click="showMessage()">テストボタン</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <button @click="toggleModal">ダイアログボタン</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <button @click="onStudy01">勉強遷移ボタン1</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Component -->
        <Modal :show="showModal" @close="toggleModal">
            <template v-slot>
                <div class="p-6">
                    <h2 class="text-xl font-semibold">モーダルタイトル</h2>
                    <p class="mt-4">ここにモーダルの内容が入ります。</p>
                    <div class="mt-6 text-right">
                        <button @click="toggleModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Close</button>
                    </div>
                </div>
            </template>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DashboardButton from '@/Components/Dashboard/DashboardButton.vue'
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router'; 

const showModal = ref(false);
const router = useRouter(); 

function showMessage() {
    alert("ボタンが押されました");
}

function toggleModal() {
    showModal.value = !showModal.value;
}

function onStudy01() {
    router.push('/study/study01');
}
</script>
<Head title="Dashboard" />
