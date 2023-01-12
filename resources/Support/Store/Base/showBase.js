import Vue from "vue";

const app = Vue.prototype

export default () => {
    return {
        mutations: {
            setShow(_, id) {
                const parameters = id ? {id} : {}

                app.$state.setShow(parameters)
            },

            resetShow() {
                app.$state.resetShow()
            }
        },
    }
}
