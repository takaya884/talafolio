import WelcomeVue from './Pages/Welcome.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: "/",
        component: WelcomeVue,
        name:'home',
    },

    // ユーザー
    { path: '/user', name: 'user.index', component: () => import('@/Pages/User/Index.vue'), props: true, meta: { hideAside: true } },
];

const router = createRouter({
    routes, // short for `routes: routes`
    history: createWebHistory(),
  })


  
export default router;