import Vue from "vue";
import formBase from "../../../../../Support/Store/Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        update({commit, getters, dispatch}, route) {
            commit('form/resetErrors')

            app.$api.call({
                url: route,
                method: 'PATCH',
                data: getters['form/data']
            }).then(() => {
                dispatch('auth/getUser', null, {root: true})
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})
            })
        }
    },

    modules: {
        form: formBase({
            withoutId: true,
            disableLoader: true,
        })
    }
}
