import Vue from 'vue';
import VueRouter from 'vue-router';
import ListDomains from './components/ListDomains.vue'
import DomainDashboard from './components/DomainDashboard.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/', redirect: '/domains'
    },
    {
        path: '/domains', component: ListDomains,
    },
    {
        path: '/domain/:domainName', component: DomainDashboard
    }
];

const router = new VueRouter({
   mode: 'history',
   routes
})

const app = new Vue({
    router
}).$mount('#app');

console.log('Alive and well');