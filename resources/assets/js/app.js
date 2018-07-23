
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// import LiquorTree from 'liquor-tree';



import VJstree from 'vue-jstree'

window.Vue.use(VJstree);

import TreeComponent from './components/TreeComponent.vue';
import Tree1Component from './components/Tree1Component.vue';
// import LiquorTreeComponent from './components/LiquorTreeComponent.vue';



const routes = [
    {
        path: '/',
        component: TreeComponent
    },
    {
        path: '/tree',
        component: Tree1Component
    }
];

const router = new VueRouter({ routes });

const app = new Vue({ router }).$mount('#app');
