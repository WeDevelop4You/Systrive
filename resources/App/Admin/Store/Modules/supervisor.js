import Vue from "vue";
import OverviewBase from "../../../../Support/Store/Base/overviewBase";
import FormBase from "../../../../Support/Store/Base/formBase";
import ShowBase from "../../../../Support/Store/Base/showBase";
import {STATE_CREATE, STATE_EDIT, STATE_SHOW} from "../../../../Support/Config/RouteState";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        create({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then(() => {
                commit('form/setCreate', {})
            })
        },

        store({commit, getters}, route) {
            return app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data']
            }).catch((errors) => {
                commit('form/setErrors', errors.response.data.errors || {})

                return Promise.reject()
            })
        },

        show({commit}, route) {
            return app.$api.call({
                url: route,
                method: "GET"
            }).then(() => {
                commit('setShow')

                return Promise.resolve()
            }).catch(() => {
                commit('resetShow')

                return Promise.reject()
            })
        },

        edit({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('form/setEdit', response.data.data)
            })
        },

        update({commit, getters}, route) {
            return app.$api.call({
                url: route,
                method: "PATCH",
                data: getters['form/data']
            }).catch((errors) => {
                commit('form/setErrors', errors.response.data.errors || {})

                return Promise.reject()
            })
        },

        states({dispatch}, action) {
            const actions = {
                [STATE_CREATE]: () => {
                    dispatch('create', app.$api.route('admin.supervisor.process.create'))
                },
                [STATE_EDIT]: () => {
                    dispatch('edit', app.$api.route('admin.supervisor.process.edit', action.params.id))
                },
                [STATE_SHOW]: () => {
                    dispatch('show', app.$api.route('admin.supervisor.show')).then(() => {
                        app.$loader.runStateAction('supervisor')
                    })
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        show: ShowBase(),
        form: FormBase(),
        overview: OverviewBase(),
    }
}
