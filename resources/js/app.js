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

import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'
Vue.use(Chartkick.use(Chart))

import es from 'vee-validate/dist/locale/es'
// Importa VeeValidate y el Validator
import VeeValidate, { Validator } from "vee-validate";
Vue.use(VeeValidate);
// Indicar uso de idioma español
Validator.localize("es", es);

// Agregamos el swwet-alert2
import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

// Ahora agregamos su toast
import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.use(VueToast);
//Vue.$toast.open({/* options */});
let instance = Vue.$toast.open('You did it!');

// Force dismiss specific toast
instance.dismiss();
// Dismiss all opened toast immediately
Vue.$toast.clear();

import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'
Vue.use(VueGoodTablePlugin);
import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueGoogleMaps, {
  load: {
        key: "AIzaSyC216yD_VOkh3YKnnNV6pbIQF2f-GDT7Ms",
        libraries:'places',
  },
});

import VueGeolocation from 'vue-browser-geolocation';
Vue.use(VueGeolocation);

import LoadScript from 'vue-plugin-load-script';
Vue.use(LoadScript);
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

// Vue.component('brand-component',require('./components/Admin/Brand/index.vue').default);
// Vue.component('unit-component',require('./components/Admin/Unit/index.vue').default);
// Vue.component('category-component',require('./components/Admin/Category/index.vue').default);
// Vue.component('product-component',require('./components/Admin/Product/index.vue').default);
// Vue.component('product-import-component',require('./components/Admin/Product/index-import.vue').default);
// Vue.component('order-component',require('./components/Store/Order/index.vue').default);
// Vue.component('order-view-component',require('./components/Store/Order/show.vue').default);
// Vue.component('orders-entregadas-component',require('./components/Store/Order/orders-entregadas.vue').default);
// Vue.component('report-component',require('./components/Admin/Report/index.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        'brand-component':()=>import('./components/Admin/Brand/index.vue'),
        'unit-component':()=>import('./components/Admin/Unit/index.vue'),
        'category-component':()=>import('./components/Admin/Category/index.vue'),
        'product-component':()=>import('./components/Admin/Product/index.vue'),
        'product-import-component':()=>import('./components/Admin/Product/index-import.vue'),
        'order-component':()=>import('./components/Store/Order/index.vue'),
        'order-view-component':()=>import('./components/Store/Order/show.vue'),
        'orders-entregadas-component':()=>import('./components/Store/Order/orders-entregadas.vue'),
        'orders-entregar-component':()=>import('./components/Store/Order/orders-entregar.vue'),
        'orders-empacar-component':()=>import('./components/Store/Order/orders-empacar.vue'),
        'report-component':()=>import('./components/Admin/Report/index.vue'),
        'chekout-component':()=>import('./components/Admin/Checkout/index.vue'),
        // 'google-map-loader-component':()=>import('./components/Store/Order/GoogleMapLoader.vue'),
        // 'google-map-line-component':()=>import('./components/Store/Order/GoogleMapLine.vue'),
        // 'google-map-marker-component':()=>import('./components/Store/Order/GoogleMapMarker.vue'),
    },
});
