import DashboardHome from '@/views/DashboardHome.vue';
import MainLayout from '@/views/layout/MainLayout.vue';
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: '/login',
        component: () => import("../views/auth/Login")
    },
    {
        path: '/register',
        component: () => import("../views/auth/Register")
    },
    {
        path: '/',
        component: MainLayout,
        children: [
            {
                path: '/',
                component: DashboardHome,
                meta: { title: 'Dashboard Home' }
            },
            {
                path: '/books',
                component: () => import("../views/books"),
                meta: { title: 'Books Page' }
            },
            {
                path: '/books/create',
                component: () => import("../views/books/create"),
                meta: { title: 'Add New Book' }
            },
            {
                path: '/books/:id',
                component: () => import("../views/books/view"),
                meta: { title: 'Book Details' }
            },
            {
                path: '/books/:id/edit',
                component: () => import("../views/books/create"),
                meta: { title: 'Edit Book' }
            },
        ],

    },
    {
        path: "/:pathMatch(.*)",
        component: () => import("../views/layout/404"),
    },
];

const router = createRouter({
    history: createWebHistory("/"),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');

    if (to.path === '/login' && isAuthenticated) {
        // User is authenticated and trying to access the login page
        next('/');
    } else if ((to.path !== '/login' && to.path !== '/register') && !isAuthenticated) {
        // User is not authenticated and trying to access a protected route
        next('/login');
    } else if (to.path === '/register' && isAuthenticated) {
        // User is authenticated and trying to access the register page
        next('/');
    } else {
        // User is either authenticated and accessing a protected route or
        // is accessing a public route or the /register route
        next();
    }
});


export default router;
