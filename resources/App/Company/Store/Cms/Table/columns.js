import Vue from "vue";
import {arrayMoveMutable} from 'array-move';
import {cloneDeep as _cloneDeep} from "lodash";
import FormBase from "../../../../../Support/Store/Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        items: [],
    }),

    mutations: {
        setItems(state, items) {
            state.items = items;
        },

        addItem(state, data) {
            state.items.push(data);
        },

        addItemAtIndex(state, {data, index}) {
            state.items.splice(index, 0, data);
        },

        replaceItem(state, {data, index}) {
            state.items.splice(index, 1, data);
        },

        replaceItemAtIndex(state, {data, originalIndex, index}) {
            state.items[originalIndex] = data;

            arrayMoveMutable(state.items, originalIndex, index)
        },

        deleteItem(state, index) {
            state.items.splice(index, 1)
        }
    },

    getters: {
        getItems(state) {
            return state.items
        },

        getReIndexedItems(state) {
            const items = _cloneDeep(state.items);

            return items.map((item, index) => {
                item.after = index

                return item
            })
        }
    },

    actions: {
        list({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('setItems', response.data.data)
            })
        },

        create({commit, rootGetters}, route) {
            app.$api.call({
                url: route,
                method: "GET",
                params: {
                    'isEditing': rootGetters['cms/table/form/isEditing']
                }
            }).then((response) => {
                commit('form/setCreate', response.data.data)
            })
        },

        edit({commit, state, rootGetters}, route) {
            app.$api.call({
                url: route,
                method: "GET",
                params: {
                    'isEditing': rootGetters['cms/table/form/isEditing']
                }
            }).then((response) => {
                const key = response.data.data
                const data = state.items.find(item => item.original_key === key)

                commit('form/setEdit', _cloneDeep(data || {}))
            })
        },

        process({state, commit, getters}, route) {
            const data = _cloneDeep(getters['form/data'])
            const keys = state.items.map(item => item.original_key).filter(item => item !== data.original_key)

            data.type = data.type.value

            return app.$api.call({
                url: route,
                method: "POST",
                data: {...data, keys},
            }).then((response) => {
                const after = data.after
                const index = state.items.findIndex(item => item.original_key === data.original_key)

                const params = (name, item) => {
                    switch (name) {
                        case 'addItem':
                            return item
                        case 'addItemAtIndex':
                            return {data: item, index: after}
                        case 'replaceItem':
                            return {data: item, index: index}
                        case 'replaceItemAtIndex':
                            return {data: item, originalIndex: index, index: after}
                    }
                }
                const runCommit = (name, data) => {
                    commit(name, params(name, data.listItem))
                    commit(`dataTable/${name}`, params(name, data.tableItem))
                }

                const isDefault = after === 'default'
                const commitName = getters['form/isEditing']
                    ? (isDefault ? 'replaceItem' : 'replaceItemAtIndex')
                    : (isDefault ? 'addItem' : 'addItemAtIndex')

                runCommit(commitName, response.data.data)

                return Promise.resolve()
            }).catch((error) => {
                commit("form/setErrors", error.response.data.errors || {})

                return Promise.reject()
            })
        },

        delete({state, commit}, key) {
            const index = state.items.findIndex(item => item.original_key === key)

            commit('deleteItem', index)
            commit('dataTable/deleteItem', index)
        }
    },

    modules: {
        form: FormBase(),
    }
}
