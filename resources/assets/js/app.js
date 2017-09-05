require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
    {path:'/users', component: require('./components/Users.vue') },
    {path:'*', component: require('./components/Example.vue')},
]

const router = new VueRouter({
    routes
})

const app = new Vue({
    router
}).$mount('#app')
