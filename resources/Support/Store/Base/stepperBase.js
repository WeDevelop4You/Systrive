export default function () {
    return {
        namespaced: true,

        state: () => ({
            step: 1,
        }),

        mutations: {
            next (state) {
                state.step++
            },

            back (state) {
                state.step--
            },

            setStep(state, value) {
                state.step = value
            },

            reset (state) {
                state.step = 1
            }
        },

        getters: {
            step(state) {
                return state.step
            },
        }
    }
}
