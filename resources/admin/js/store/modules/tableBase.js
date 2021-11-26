import Router from '../../plugins/routes'

export default {
    state: () => ({
        data: {},
        items: [],
        errors: {},
        structure: {},

        isShowDialogOpen: false,

        isEditing: false,
        isCreateOrEditDialogOpen: false,

        deleteId: null,
        deleteMessage: '',
        isDeleteDialogOpen: false,

        hideDeleteButton: false,

        isLoadActionAllowed: false,
        loadActions: {
            new: {
                isAllowed: true,
                isIdAllowed: false,
                func: ({commit}) => {
                    commit('setCreate')
                }
            },
            edit: {
                isAllowed: true,
                isIdAllowed: true,
                func: ({dispatch}, id) => {
                    dispatch('getOne', id)
                }
            },
        }
    }),

    mutations: {
        setItems(state, items) {
            state.items = items
        },

        setErrors(state, error) {
            state.errors = error
        },

        setStructure(state, structure) {
            state.data = structure
            state.structure = structure
        },

        async setCreate(state) {
            state.data = Object.assign({}, state.structure)

            if (state.isLoadActionAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name,
                    params: {type: 'new'}
                }).catch(() => {
                })
            }

            state.isCreateOrEditDialogOpen = true
        },

        async setShow(state, id) {
            if (state.isLoadActionAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name,
                    params: {type: 'show', id: id}
                }).catch(() => {
                })
            }

            state.isShowDialogOpen = true
        },

        async setEdit(state, data) {
            if (state.isLoadActionAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name,
                    params: {type: 'edit', id: data.id}
                }).catch(() => {
                })
            }

            state.data = data
            state.isEditing = true
            state.isCreateOrEditDialogOpen = true
        },

        setDelete(state, {id, message, hideDelete = false}) {
            state.deleteId = id
            state.deleteMessage = message
            state.isDeleteDialogOpen = true
            state.hideDeleteButton = hideDelete
        },

        resetErrors(state) {
            state.errors = {}
        },

        async resetShow(state) {
            if (state.isLoadActionAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name
                }).catch(() => {
                })
            }

            state.isShowDialogOpen = false
        },

        async resetCreateOrEdit(state) {
            if (state.isLoadActionAllowed) {
                await Router.replace({
                    name: Router.currentRoute.name
                }).catch(() => {
                })
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
                state.deleteId = null
                state.deleteMessage = ''
                state.hideDeleteButton = false
            }, 300)
        },

        changeAllowedLoadAction(state, allowed) {
            state.isLoadActionAllowed = allowed
        },

        addLoadAction(state, {actionName, action}) {
            state.loadActions[actionName] = action
        },

        changeAllowedForSpecificLoadAction(state, {actionName, allowed}) {
            if (Object.prototype.hasOwnProperty.call(state.loadActions, actionName)) {
                state.loadActions[actionName].isAllowed = allowed
            }
        },
    },

    getters: {
        data(state) {
            return state.data
        },

        items(state) {
            return state.items
        },

        errors(state) {
            return state.errors
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
            return state.deleteMessage
        },

        hideDeleteButton(state) {
            return state.hideDeleteButton
        }
    },

    actions: {
        async load(service) {
            const route = Router.currentRoute
            const type = route.params.type

            service.commit('changeAllowedLoadAction', true)

            if (type !== undefined) {
                const action = service.state.loadActions[type]

                if (action && action.isAllowed) {
                    if (action.isIdAllowed) {
                        const id = route.params.id

                        if (id !== undefined) {
                            action.func(service, id)

                            return
                        }
                    } else {
                        action.func(service)

                        return
                    }
                }

                await Router.replace({name: route.name})
            }
        }
    }
}
