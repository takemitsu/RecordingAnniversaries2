require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.component('pagination', require('laravel-vue-pagination'))

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const routes = [
    {path:'/users',      name: "users", component: require('./components/User/List.vue') },
    {path:'/user/:uuid', name: "user", component: require('./components/User/Edit.vue')},

    {path:'/', name: "home", component: require('./components/Anniv/Annivs.vue')},
    {path:'/dashboard', name: "annivs", component: require('./components/Anniv/Annivs.vue')},

    {path:'/groups', name: "groups", component: require('./components/Group/List.vue')},
    {path:'/group/:id', name: "group", component: require('./components/Group/Show.vue')},
    {path:'/group/:id/edit', name: "group_edit", component: require('./components/Group/Edit.vue')},

    {path:'/anniv/:id/edit', name: "anniv_edit", component: require('./components/Anniv/Edit.vue')},

    {path:'/oauth', name: "oauth", component: require('./components/OAuth/OAuth.vue')},

    {path:'*', component: require('./components/Other.vue')},
]

const router = new VueRouter({
    routes
})

const app = new Vue({
    router
}).$mount('#app')
