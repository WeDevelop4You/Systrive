import Vue from 'vue';
import OverviewBase from "../../../../Support/Store/Base/overviewBase";
import FormBase from "../../../../Support/Store/Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        edit({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('form/setEdit', response.data.data)
            })
        },

        // update({commit, getters}, route) {
        //
        // }
    },

    modules: {
        form: FormBase({
            withoutId: true
        }),
        overview: OverviewBase
    }
}
