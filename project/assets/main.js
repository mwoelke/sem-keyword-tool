import Vue from 'vue';
import VueRouter from 'vue-router';
import ListDomains from './components/ListDomains.vue';
import DomainDashboard from './components/DomainDashboard.vue';
import MainHeader from './components/MainHeader.vue';
import Store from './lib/store';
import Import from './components/Import';
import KeywordList from './components/KeywordList'
import EditKeyword from './components/EditKeyword'
import AssignmentRules from './components/AssignmentRules.vue'

Vue.use(VueRouter)

//load Domains
Store.data.loadDomains(1);

const routes = [
    {
        path: '/', 
        redirect: '/domains', 
        props: {store: Store}
    },
    {
        path: '/domains', 
        component: ListDomains,
        props: {store: Store}
    },
    {
        path: '/dashboard', 
        component: DomainDashboard,
        props: {store: Store}
    },
    {
        path: '/import',
        component: Import,
        props: {store: Store}
    },
    {
        path: '/keywords/:keyword_group?',
        component: KeywordList,
        props: {store: Store}
    },
    {
        path: '/keyword/:keyword',
        component: EditKeyword,
        props: {store: Store}
    },
    {
        path: '/rules',
        component: AssignmentRules,
        props: {store: Store}
    },
];

const router = new VueRouter({
   mode: 'history',
   routes
});

const app = new Vue({
    components : {
        MainHeader
    },
    router
}).$mount('#app');

