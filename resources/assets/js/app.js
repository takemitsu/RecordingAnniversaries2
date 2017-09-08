require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.component('pagination', require('laravel-vue-pagination'))

const routes = [
    {path:'/users',      name: "users", component: require('./components/User/List.vue') },
    {path:'/user/:uuid', name: "user", component: require('./components/User/Edit.vue')},
    {path:'/dashboard', component: require('./components/Dashboard.vue')},
    {path:'/annivs', component: require('./components/Anniv/Annivs.vue')},

    {path:'/groups', name: "groups", component: require('./components/Group/List.vue')},
    {path:'/group/:id', name: "group", component: require('./components/Group/Show.vue')},
    {path:'/group/:id/edit', name: "group_edit", component: require('./components/Group/Edit.vue')},

    {path:'/anniv/:id/edit', name: "anniv_edit", component: require('./components/Anniv/Edit.vue')},

    {path:'*', component: require('./components/Dashboard.vue')},
]

const router = new VueRouter({
    routes
})

const app = new Vue({
    router
}).$mount('#app')
