import Vue from "vue";

const app = Vue.prototype

export default {
    mutations: {
        setShow(_, id) {
            const parameters = id ? {id} : {}

            app.$routeLoader.setShow(parameters)
        },

        resetShow() {
            app.$routeLoader.resetShow()
        }
    },
}
