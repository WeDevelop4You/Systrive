import Vue from "vue";

const app = Vue.prototype
const defaultOptions = {
    isReady: false,
    isEditing: false,
    withoutId: false,
    disableLoader: false,
}

export default function (options) {
    options = {...defaultOptions, ...options}

    return {
        namespaced: true,

        state: () => ({
            data: {},
            error: false,
            errors: {},
            isReady: options.isReady,
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
                    app.$state.setForm(false, state.parameters)
                }

                state.data = data
                state.isReady = true
            },

            setEdit(state, data) {
                if (!options.disableLoader) {
                    const parameters = options.withoutId
                        ? {...state.parameters}
                        : {...state.parameters, id: data.id}

                    app.$state.setForm(true, parameters)
                }

                state.data = data
                state.isEditing = true
                state.isReady = true
            },

            setEditing(state) {
                state.isEditing = true
            },

            resetForm(state) {
                if (!options.disableLoader) {
                    app.$state.resetForm()
                }

                setTimeout(() => {
                    state.data = {}
                    state.errors = {}
                    state.error = false
                    state.isReady = options.isReady
                    state.isEditing = options.isEditing
                }, 300)
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

            error(state) {
                return state.error
            },

            errors(state) {
                return state.errors
            },

            isEditing(state) {
                return state.isEditing
            },

            isReady(state) {
                return state.isReady
            }
        }
    }
}
