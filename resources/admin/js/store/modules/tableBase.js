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

        loadActions: {
            'new' : {
                allowId: false,
                func: ({commit}) => {
                    commit('setCreate')
                }
            },
            'show' : {
                allowId: true,
                func: ({dispatch}, id) => {
                    dispatch('getOne', {id: id, showDialog: true})
                }
            },
            'edit' : {
                allowId: true,
                func: ({dispatch}, id) => {
                    dispatch('getOne', {id: id})
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

        setCreate(state) {
            Object.assign(state.data, state.structure)

            state.isCreateOrEditDialogOpen = true
        },

        setShow(state, data) {
            state.data = data
            state.isShowDialogOpen = true
        },

        setEdit(state, data) {
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

        resetShow(state) {
            state.isShowDialogOpen = false
        },

        resetCreateOrEdit(state) {
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

        addLoadAction(state, actionName, action) {
            state.loadActions[actionName] = action
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

            if (type !== undefined) {
                const action = service.state.loadActions[type]

                if (action) {
                    if (action.allowId) {
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
