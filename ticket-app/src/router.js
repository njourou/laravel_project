// src/router.js
import { createRouter, createWebHistory } from 'vue-router';
import UserView from './views/UserView.vue';
import AdminView from './views/AdminView.vue';

const routes = [
  {
    path: '/',
    name: 'user',
    component: UserView,
  },
  {
    path: '/admin',
    name: 'admin',
    component: AdminView,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
