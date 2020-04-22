/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

import router from './router'
import store from './store'

window.Vue = Vue
Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Vue.component('', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// router.beforeEach((to, from, next) => {
  // console.log('to: ' + to);
  // console.log('from: ' + from);
  // console.log('next: ' + next);
  // if (to.matched.some(record => record.meta.requiresAuth) && !Auth.loggedIn) {
  //   next({ path: '/login', query: { redirect: to.fullPath }});
  // } else {
  //   next();
  // }
// });

const app = new Vue({
    el: '#app',
    router,
    store
});
