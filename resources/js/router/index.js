import { createRouter, createWebHistory } from "vue-router";

import Order from '../components/pages/Order.vue'
import NotFound from '../components/pages/NotFound.vue'
import Login from '../components/pages/Login.vue'
import OrderList from "../components/pages/OrderList.vue";
import OrderShow from "../components/pages/OrderShow.vue";
import OrderEdit from "../components/pages/OrderEdit.vue";
const routes = [
    {
        path : '/',
        component : Order,
        name : 'order',
        meta : {requiresAuth : true}
    },
    {
        path : '/order-list',
        component : OrderList,
        name : 'order-list',
        meta : {requiresAuth : true}
    },
    {
        path : '/order/:id',
        component : OrderShow,
        name : 'order-show',
        meta : {requiresAuth : true}
    },
    {
        path : '/order/:id/edit',
        component : OrderEdit,
        name : 'order-edit',
        meta : {requiresAuth : true}
    },
    {
        path : '/login',
        component : Login,
        name : 'login'
    },
    {
        path : '/:pathMatch(.*)*',
        component : NotFound
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        const token = localStorage.getItem('token'); // Atau gunakan Vuex
        if (!token) {
            next({ name: 'login' });
        } else {
            next()
        }
    } else {
        next();
    }
});


export default router
