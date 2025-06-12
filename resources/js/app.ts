import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import './bootstrap';

// ルーターの設定
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import('./views/auth/Login.vue'),
            meta: { requiresAuth: false }
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: () => import('./views/Dashboard.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/memo',
            name: 'memo',
            component: () => import('./views/memo/Index.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/news',
            name: 'news',
            component: () => import('./views/news/Index.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/session',
            name: 'session',
            component: () => import('./views/session/Index.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/email',
            name: 'email',
            component: () => import('./views/email/Index.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/cron',
            name: 'cron',
            component: () => import('./views/cron/Index.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/register',
            name: 'register',
            component: () => import('./views/auth/Register.vue'),
            meta: { requiresAuth: false }
        }
    ]
});

// ナビゲーションガード
router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');
    
    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/login');
    } else if (to.path === '/login' && isAuthenticated) {
        next('/dashboard');
    } else {
        next();
    }
});

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app'); 