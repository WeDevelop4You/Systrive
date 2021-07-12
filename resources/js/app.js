require('./bootstrap')

import Vue from 'vue'
import Init from './layout/Init'
import Router from './plugins/routes'
import Vuetify from './plugins/vuetify'

Vue.config.productionTip = false

Vue.component('app-init', Init);

export default new Vue({
    el: '#app',
    vuetify: Vuetify,
    router: Router,
});
