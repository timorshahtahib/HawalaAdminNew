/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import './bootstrap';
import { createApp } from 'vue';
import routes from './router/index'
import App from '../js/App.vue'
import VueApexCharts from "vue3-apexcharts";
import helper from "./mixins/layouts.mixin";
import Vuelidate from "vuelidate";
import Maska from 'maska'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import i18n from './i18n'
import { BootstrapVueNext } from 'bootstrap-vue-next';

// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'
import "leaflet/dist/leaflet.css";




/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

app.component("example-component", App);
app.use(routes);
app.use(App);
app.use(i18n);
app.use(Maska);
app.mixin(helper);
app.use(Vuelidate);
app.use(VueApexCharts);
app.use(BootstrapVueNext);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');