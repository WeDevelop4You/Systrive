import Vue from 'vue';
import { v4 as uuidGenerator } from 'uuid';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        modal: {
            data: {},
            show: false
        },
        notifications: []
    }),

    mutations: {
        setModal(state, data) {
            state.modal = data
        },

        addNotifications(state, data) {
            state.notifications.push(data)
        },

        removeNotifications(state, id) {
            const index = state.notifications.findIndex(notification => notification.id === id)

            if (index !== -1) {
                state.notifications.splice(index, 1)
            }
        },

        closeModal(state) {
            state.modal.show = false
        }
    },

    getters: {
        modal(state) {
            return state.modal
        },

        notifications(state) {
            return state.notifications
        }
    },

    actions: {
        addPopup({commit}, content) {
            const data = content.data
            const type = content.type

            if (type === 'notification') {
                commit('addNotifications', content)

                if (!data.stayable) {
                    const displayTime = data.time || app.$config.notification.displayTime

                    setTimeout(() => {
                        commit('removeNotifications', content.id)
                    }, displayTime);
                }
            } else if (type === 'modal') {
                commit('setModal', content)
            }
        },

        addNotification({dispatch}, {message, type = 'error'}) {
            dispatch(
                'addPopup',
                {
                    id: uuidGenerator(),
                    type: "notification",
                    component: "SimpleNotification",
                    data: {
                        stayable: false,
                        message: {
                            type: type,
                            text: message
                        }
                    }
                },
            )
        }
    },
}
