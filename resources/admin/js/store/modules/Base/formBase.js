import Vue from "vue";

const app = Vue.prototype
const defaultOptions = {
    isEditing: false,
    disableLoader: false,
}

export default function (options = defaultOptions) {
    return {
        namespaced: true,

        state: () => ({
            status: 'loading',
            data: {},
            errors: {},
            error: false,
            isEditing: options.isEditing,
            parameters: {},
        }),

        mutations: {
            setData(state, data) {
                state.data = data
            },

            setError(state, value) {
                state.error = value
            },

            setErrors(state, errors) {
                state.errors = errors || {}
            },

            resetErrors(state) {
                state.errors = {}
                state.error = false;
            },

            setCreate(state, data) {
                if (!options.disableLoader) {
                    app.$routeLoader.setForm(false, state.parameters)
                }

                state.data = data
                state.status = 'ready'
            },

            setEdit(state, data) {
                if (!options.disableLoader) {
                    app.$routeLoader.setForm(true, {...state.parameters, id: data.id})
                }

                state.data = data
                state.isEditing = true
                state.status = 'ready'
            },

            resetForm(state) {
                if (!options.disableLoader) {
                    app.$routeLoader.resetForm()
                }

                setTimeout(() => {
                    state.data = {}
                    state.errors = {}
                    state.error = false;
                    state.isEditing = options.isEditing
                }, 300)

                state.status = 'reset'
            },

            setType(state, type) {
                state.parameters.type = type
            },

            resetParameters(state) {
                state.parameters = {}
            },
        },

        getters: {
            data(state) {
                return state.data
            },

            status(state) {
                return state.status
            },

            error(state) {
                return state.error
            },

            errors(state) {
                return state.errors
            },

            isEditing(state) {
                return state.isEditing
            },
        }
    }
}
