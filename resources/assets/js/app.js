require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.component('pagination', require('laravel-vue-pagination'))

const routes = [
    {path:'/users',      name: "users", component: require('./components/User/List.vue') },
    {path:'/user/:uuid', name: "user", component: require('./components/User/Edit.vue')},
    {path:'*', component: require('./components/Example.vue')},
]

const router = new VueRouter({
    routes
})

const app = new Vue({
    router
}).$mount('#app')
