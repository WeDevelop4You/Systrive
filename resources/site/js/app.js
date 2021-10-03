require('./bootstrap');
import 'aos/dist/aos.css';

import Vue from 'vue'
import AOS from 'aos';
import axios from 'axios'
import router from './routes'
import VueMeta from 'vue-meta'
import VueRouter from 'vue-router'
import Index from './components/Index'

// Set Vue globally
window.Vue = Vue;

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);

Vue.use(VueMeta);

// Set Vue authentication
axios.defaults.baseURL = `/api`;


// Load Index
Vue.component('Index', Index);

const app = new Vue({
    el: '#app',
    created() {
        AOS.init({ disable: "phone" });
    },
    router,
});

export default app;
