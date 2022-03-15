import Vue from "vue";
import Router from '../../../plugins/routes'

const app = Vue.prototype

export default {
    state: () => ({
        data: {},
        errors: {},
        structure: {},

        items: [],
        headers: [],
        meta: {
            total: -1,
            params: {},
            routes: {
                items: '',
                headers: '',
            },
        },

        isEditing: false,
        isDeleteModalOpen: false,
        isOverviewModalOpen: false,
        isCreateOrEditModalOpen: false,

        delete: {
            id: null,
            item: '',
            deleted: false,
        },

        isActionsAllowed: true,
        loadActions: {
            new: ({commit}) => {
                commit('setCreate')
            },
            edit: ({dispatch}, params) => {
                dispatch('getOne', params.id)
            },
        }
    }),

    mutations: {
        setRoutes(state, routes) {
            state.meta.routes = routes
        },

        setItemRoute(state, route) {
            state.meta.routes.items = route
        },

        setParams(state, params) {
            state.meta.params = params
        },

        setHeaders(state, headers) {
            state.headers = headers
        },

        setItems(state, items) {
            state.items = items
        },

        setTotal(state, total) {
            state.meta.total = total
        },

        setData(state, data) {
            state.date = data
        },

        setErrors(state, error) {
            state.errors = error || {}
        },

        setStructure(state, structure) {
            state.data = structure
            state.structure = structure
        },

        async setCreate(state) {
            state.data = Object.assign({}, state.structure)

            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name,
                    params: {type: 'new'}
                }).catch(() => {})
            }

            state.isCreateOrEditModalOpen = true
        },

        async setEdit(state, data) {
            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name,
                    params: {type: 'edit', id: data.id}
                }).catch(() => {})
            }

            state.data = data
            state.isEditing = true
            state.isCreateOrEditModalOpen = true
        },

        async setOverview(state, id) {
            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name,
                    params: {type: 'show', id: id}
                }).catch(() => {})
            }

            state.isOverviewModalOpen = true
        },

        setDelete(state, {id, itemName, deleted = false}) {
            state.delete = {
                id: id,
                item: itemName,
                deleted: deleted,
            }

            state.isDeleteModalOpen = true
        },

        async resetCreateOrEdit(state) {
            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name
                }).catch(() => {})
            }

            state.errors = {}
            state.isCreateOrEditModalOpen = false

            setTimeout(() => {
                state.isEditing = false
            }, 300)
        },

        async resetOverview(state) {
            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name
                }).catch(() => {})
            }

            state.isOverviewModalOpen = false
        },

        resetDelete(state) {
            state.isDeleteModalOpen = false

            setTimeout(() => {
                state.delete = {
                    id: null,
                    item: '',
                    deleted: false
                }
            }, 300)
        },

        resetErrors(state) {
            state.errors = {}
        },

        useActions(state, allowed) {
            state.isActionsAllowed = allowed
        },

        addLoadAction(state, {actionType, action}) {
            state.loadActions[actionType] = action
        },

        removeLoadAction(state, actionType) {
            delete state.loadActions[actionType]
        }
    },

    getters: {
        data(state) {
            return state.data
        },

        headers(state) {
            return state.headers
        },

        items(state) {
            return state.items
        },

        total(state) {
            return state.meta.total
        },

        errors(state) {
            return state.errors || {}
        },

        isEditing(state) {
            return state.isEditing
        },

        isCreateOrEditModalOpen(state) {
            return state.isCreateOrEditModalOpen
        },

        isOverviewModalOpen(state) {
            return state.isOverviewModalOpen
        },

        isDeleteModalOpen(state) {
            return state.isDeleteModalOpen
        },

        deleteItem(state) {
            return state.delete.item
        },

        isDeleted(state) {
            return state.delete.deleted
        }
    },

    actions: {
        async load(service) {
            const route = Router.currentRoute
            const params = route.params

            if (params.type !== undefined) {
                const actionType = service.state.loadActions[params.type]

                if (actionType !== undefined) {
                    actionType(service, params)

                    return
                }

                await Router.replace({name: route.name})
            }
        },

        getHeaders({state, commit}) {
            app.$api.call({
                url: state.meta.routes.headers,
                method: "GET"
            }).then((response) => {
                commit('setHeaders', response.data)
            })
        },

        getItems({state, commit}, route = undefined) {
            if (route) {
                commit('setItemRoute', route)
            }

            app.$api.call({
                url: state.meta.routes.items,
                method: "GET",
                params: state.meta.params
            }).then((response) => {
                const data = response.data

                commit('setItems', data.data)
                commit('setTotal', data.meta.total)
            })
        }
    }
}
