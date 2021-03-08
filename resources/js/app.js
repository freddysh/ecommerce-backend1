/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 import Vue from 'vue'
require('./bootstrap');
require('alpinejs');
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css' ;
window.Vue = require('vue').default;
import VuePaginate from 'vue-paginate';
Vue.use(VuePaginate);
Vue.use(Vuesax);

import moment from 'moment'
import 'moment/locale/es';
Vue.prototype.moment = moment
Vue.use(require('vue-moment'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('brand-component',require('./components/Admin/Brand/index.vue').default);
Vue.component('unit-component',require('./components/Admin/Unit/index.vue').default);
Vue.component('category-component',require('./components/Admin/Category/index.vue').default);
Vue.component('product-component',require('./components/Admin/Product/index.vue').default);
Vue.component('product-import-component',require('./components/Admin/Product/index-import.vue').default);
Vue.component('order-component',require('./components/Store/Order/index.vue').default);
Vue.component('order-view-component',require('./components/Store/Order/show.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
