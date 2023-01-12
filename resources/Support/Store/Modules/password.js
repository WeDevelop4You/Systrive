export default {
    namespaced: true,

    state: () => ({
        errors: {},
        error: false
    }),

    mutations: {
        setError(state, value) {
            state.error = value
        },

        setErrors(state, errors) {
            state.errors = errors
        }
    },

    getters: {
        error(state) {
            return state.error
        },

        errors(state) {
            return state.errors
        }
    },

    actions: {
        errors({commit}, errors) {
            let newErrors = {}

            commit('setError', false)

            errors.password?.forEach((message) => {
                commit('setError', true)

                if (message.includes('characters')) {
                    newErrors.characters = true
                } else if (message.includes('uppercase')) {
                    newErrors.mixedCase = true
                } else if (message.includes('number')) {
                    newErrors.number = true
                } else if (message.includes('symbol')) {
                    newErrors.symbol = true
                } else {
                    newErrors.password = [
                        ...newErrors.password || [],
                        message
                    ]
                }
            })

            delete errors.password

            commit('setErrors', {...errors, ...newErrors})
        },
    }
}
