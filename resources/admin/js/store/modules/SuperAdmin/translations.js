import Vue from 'vue';
import dataTableBase from "../../base/dataTableBase";
import FormBase from "../../base/formBase";
import {STATE_EDIT} from "../../../config/RouteState";

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

        update({getters}, route) {
            const data = getters['form/data']

            return app.$api.call({
                url: route,
                method: "PATCH",
                data: {
                    translations: data.translations
                }
            })
        },

        changeEnvironment({getters, commit}, name) {
            const data = getters['environmentForm/data']

            commit('dataTable/setItemRoute', app.$api.route(name, data.environment))
            commit('dataTable/resetParams')
        },

        states({dispatch}, action) {
            const actions = {
                [STATE_EDIT]: () => {
                    dispatch('edit', app.$api.route('admin.translation.edit', action.params.id));
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        dataTable: dataTableBase,
        environmentForm: FormBase(),
        form: FormBase(),
    },
}
