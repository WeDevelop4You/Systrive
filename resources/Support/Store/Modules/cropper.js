export default function (options) {
    return {
        namespaced: true,

        state: () => ({
            queue: [],
            coordinates: {}
        }),

        getters: {
            file(state) {
                return state.queue.at(0)
            },

            coordinates(state) {
                return state.coordinates
            }
        },

        mutations: {
            add(state, item) {
                state.queue.push(item);

                options.modalCallback.call(this, true)
            },

            setCoordinates(state, data) {
                state.coordinates = data
            },

            remove(state) {
                state.coordinates = {}
                state.queue.splice(0, 1)

                options.modalCallback.call(this, state.queue.length > 0)
            }
        },

        actions: {
            cancel({commit}) {
                commit('remove')
            },

            save({commit, getters}) {
                options.uploaderCallback.call(
                    this,
                    getters['file'],
                    getters['coordinates']
                ).then(() => {
                    commit('remove')
                })
            }
        }
    }
}