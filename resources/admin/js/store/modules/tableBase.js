export default {
    state: () => ({
        data: {},
        items: [],
        errors: {},
        structure: {},

        isEditing: false,
        isCreateOrEditDialogOpen: false,

        deleteId: null,
        deleteMessage: '',
        isDeleteDialogOpen: false,

        hideDeleteButton: false,
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

    }
}
