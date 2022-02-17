import Router from '../../../plugins/routes'

export default {
    state: () => ({
        data: {},
        items: [],
        errors: {},
        structure: {},

        isEditing: false,
        isShowDialogOpen: false,
        isDeleteDialogOpen: false,
        isCreateOrEditDialogOpen: false,

        delete: {
            id: null,
            message: '',
            hideButton: false,
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

            state.isCreateOrEditDialogOpen = true
        },

        async setShow(state, id) {
            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name,
                    params: {type: 'show', id: id}
                }).catch(() => {})
            }

            state.isShowDialogOpen = true
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
            state.isCreateOrEditDialogOpen = true
        },

        setDelete(state, {id, message, hideButton = false}) {
            state.delete = {
                id: id,
                message: message,
                hideButton: hideButton
            }

            state.isDeleteDialogOpen = true
        },

        resetErrors(state) {
            state.errors = {}
        },

        async resetShow(state) {
            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name
                }).catch(() => {})
            }

            state.isShowDialogOpen = false
        },

        async resetCreateOrEdit(state) {
            if (state.isActionsAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name
                }).catch(() => {})
            }

            state.errors = {}
            state.isCreateOrEditDialogOpen = false

            setTimeout(() => {
                state.isEditing = false
            }, 300)
        },

        resetDelete(state) {
            state.isDeleteDialogOpen = false

            setTimeout(() => {
                state.delete = {
                    id: null,
                    message: '',
                    hideButton: false
                }
            }, 300)
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

        isShowDialogOpen(state) {
            return state.isShowDialogOpen
        },

        isEditing(state) {
            return state.isEditing
        },

        isCreateOrEditDialogOpen(state) {
            return state.isCreateOrEditDialogOpen
        },

        isDeleteDialogOpen(state) {
            return state.isDeleteDialogOpen
        },

        deleteMessage(state) {
            return state.delete.message
        },

        hideDeleteButton(state) {
            return state.delete.hideButton
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