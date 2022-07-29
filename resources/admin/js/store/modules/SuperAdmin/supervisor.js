import Vue from "vue";
import OverviewBase from "../Base/overviewBase";
import FormBase from "../Base/formBase";
import ShowBase from "../Base/showBase";
import DataTableBase from "../Base/dataTableBase";

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
                new: () => {
                    dispatch('create', app.$api.route('admin.supervisor.process.create'))
                },
                edit: () => {
                    dispatch('edit', app.$api.route('admin.supervisor.process.edit', action.params.id))
                },
                show: () => {
                    dispatch('show', app.$api.route('admin.supervisor.show')).then(() => {
                        app.$routeLoader.runStateAction('supervisor')
                    })
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        show: ShowBase,
        form: FormBase(),
        overview: OverviewBase,
        dataTable: DataTableBase
    }
}
