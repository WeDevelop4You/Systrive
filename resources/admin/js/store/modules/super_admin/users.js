import Vue from 'vue';
import dataTableBase from "../base/dataTableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({

    }),

    mutations: {

    },

    getters: {
        structure() {
            return {
                email: '',
                fullName: '',
                verified: false,
                emailVerifiedAt: '',
                createdAt: ''
            }
        }
    },

    actions: {
        getOne({commit}, {id, showDialog = false}) {
            console.log(commit, id, showDialog)
        },

        destroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.user', state.dataTable.delete.id),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },

        forceDestroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.force', state.dataTable.delete.id),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        }
    },

    modules: {
        dataTable: dataTableBase
    }
}
