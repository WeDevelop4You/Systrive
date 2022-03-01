import Router from '../../../plugins/routes'

export default {
    state: () => ({
        data: {},
        items: [],
        errors: {},
        structure: {},

        isEditing: false,
        isDeleteModalOpen: false,
        isOverviewModalOpen: false,
        isCreateOrEditModalOpen: false,

        delete: {
            id: null,
            message: '',
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
        setItems(state, items) {
            state.items = items
        },

        setDate(state, data) {
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

        setDelete(state, {id, message = undefined, deleted = false}) {
            state.delete = {
                id: id,
                message: message,
                deleted: deleted
            }

            state.isDeleteModalOpen = true
        },

        resetErrors(state) {
            state.errors = {}
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

        resetDelete(state) {
            state.isDeleteModalOpen = false

            setTimeout(() => {
                state.delete = {
                    id: null,
                    message: '',
                    hideButton: false
                }
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

        items(state) {
            return state.items
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

        deleteMessage(state) {
            return state.delete.message
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
        }
    }
}
