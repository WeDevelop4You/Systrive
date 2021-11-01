import Vue from 'vue';
import tableBase from "../tableBase";

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
                url: app.$api.route('admin.user', state.tableBase.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },

        forceDestroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.force', state.tableBase.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        }
    },

    modules: {
        tableBase: tableBase
    }
}
