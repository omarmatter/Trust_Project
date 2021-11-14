require('./bootstrap');
import vue from 'vue'
window.Vue = vue;

import App from './components/App.vue';
import { saveAs } from 'file-saver';
//importamos Axios
import VueAxios from 'vue-axios';
import axios from 'axios';

//Importamos y configuramos el Vue-router
import VueRouter from 'vue-router';
import {routes} from './router';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

import Vue from 'vue'
import { BootstrapVue } from 'bootstrap-vue'

Vue.use(BootstrapVue)


import VueConfirmDialog from 'vue-confirm-dialog'

Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)


const router = new VueRouter({
    mode: 'history',
    routes: routes
});

//finalmente, definimos nuestra app de Vue
const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
