import Vue from "vue";
import FormBase from "../../Base/formBase";
import NotificationComponent from "../../../Helpers/Components/NotificationComponent";
import {STATE_CREATE, STATE_EDIT} from "../../../Config/RouteState";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        create({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) =>  {
                commit('form/setCreate', response.data.data)
            })
        },

        store({commit, dispatch, getters}, route) {
            return app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data']
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                commit("form/setErrors", errors)

                if (Object.prototype.hasOwnProperty.call(errors, 'permissions')) {
                    dispatch('popups/addPopup', NotificationComponent.createSimple(errors.permissions[0]), {root: true})
                }

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

        update({commit, dispatch, getters}, route) {
            return app.$api.call({
                url: route,
                method: 'PATCH',
                data: getters['form/data']
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                commit("form/setErrors", errors)

                if (Object.prototype.hasOwnProperty.call(errors, 'permissions')) {
                    dispatch('popups/addPopup', NotificationComponent.createSimple(errors.permissions[0]), {root: true})
                }

                return Promise.reject()
            })
        },

        states({dispatch}, action) {
            const actions = {
                [STATE_CREATE]: () => {
                    dispatch('create', app.$api.companyRoute('company.role.create'))
                },
                [STATE_EDIT]: () => {
                    dispatch('edit', app.$api.companyRoute('company.role.edit', action.params.id))
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        form: FormBase(),
    }
}
