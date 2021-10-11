export default {
    state: () => ({
        editDialog: false,

        deleteId: null,
        deleteMessage: '',
        deleteDialog: false,
    }),

    mutations: {
        changeEditDialog(state, value) {
            state.editDialog = value
        },

        changeDeleteDialog(state, value) {
            state.deleteDialog = value
        },

        setDelete(state, {id, message}) {
            state.deleteId = id
            state.deleteMessage = message
            state.deleteDialog = true
        },

        resetDelete(state) {
            state.deleteId = null
            state.deleteMessage = ''
            state.deleteDialog = false
        }
    },

    getters: {
        editDialog(state) {
            return state.editDialog
        },

        deleteDialog(state) {
            return state.deleteDialog
        },

        deleteMessage(state) {
            return state.deleteMessage
        }
    }
}
