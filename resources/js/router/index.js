import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../components/Home'
import ExtendedItem from '../components/ExtendedItem'
import AppNotFound from '../components/AppNotFound'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/item/:hashName',
        name: 'Item',
        component: ExtendedItem,
        props: true
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: AppNotFound
    }
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router
