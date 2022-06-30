import Vue from "vue";

const app = Vue.prototype

export default {
    mutations: {
        setShow(_, id) {
            app.$routeLoader.setShow({id})
        },

        resetShow() {
            app.$routeLoader.resetShow()
        }
    },
}
