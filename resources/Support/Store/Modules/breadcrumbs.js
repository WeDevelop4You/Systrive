export default {
    namespaced: true,

    state: () => ({
        items: [],
    }),

    getters: {
        items(state) {
            return state.items
        }
    },

    mutations: {
        add(state, item) {
            state.items.push(item);
        },

        remove(state) {
            const index = state.items.findIndex(
                (item) => Object.prototype.hasOwnProperty.call(item.additional, 'added')
            )

            if (index > -1) {
                state.items.splice(index, state.items.length - index)
            }
        },

        reset(state) {
            state.items = []
        }
    }
}