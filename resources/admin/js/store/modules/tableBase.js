export default {
    state: () => ({
        data: [],

        editDialog: false,

        deleteId: null,
        deleteMessage: '',
        deleteDialog: false,

        hideDeleteButton: false,
    }),

    mutations: {
        setData(state, data) {
            state.data = data;
        },

        changeEditDialog(state, value) {
            state.editDialog = value
        },

        changeDeleteDialog(state, value) {
            state.deleteDialog = value
        },

        setDelete(state, {id, message, hideDelete = false}) {
            state.deleteId = id
            state.deleteMessage = message
            state.deleteDialog = true
            state.hideDeleteButton = hideDelete
        },

        resetDelete(state) {
            state.deleteDialog = false

            setTimeout(() => {
                state.deleteId = null
                state.deleteMessage = ''
                state.hideDeleteButton = false
            }, 300)
        }
    },

    getters: {
        data(state) {
            return state.data
        },

        editDialog(state) {
            return state.editDialog
        },

        deleteDialog(state) {
            return state.deleteDialog
        },

        deleteMessage(state) {
            return state.deleteMessage
        },

        hideDeleteButton(state) {
            return state.hideDeleteButton
        }
    }
}
