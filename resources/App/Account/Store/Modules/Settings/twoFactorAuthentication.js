import Vue from "vue";
import FormBase from "../../../../../Support/Store/Base/formBase";
import StepperBase from "../../../../../Support/Store/Base/stepperBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        send({commit, getters}, route) {
            return app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data']
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})

                return Promise.reject()
            })
        },
    },

    modules: {
        form: FormBase({
            isReady: true,
            withoutId: true,
            disableLoader: true,
        }),
        stepper: StepperBase()
    }
}
