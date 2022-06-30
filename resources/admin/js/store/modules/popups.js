import Vue from 'vue';
import { v4 as uuidGenerator } from 'uuid';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        modals: [],
        notifications: []
    }),

    mutations: {
        addModal(state, data) {
            state.modals.push(data)
        },

        addNotification(state, data) {
            state.notifications.push(data)
        },

        removeAllModals(state) {
            for (const [index] of state.modals) {
                state.modals[index].show = false

                setTimeout(() => {
                    state.modals.splice(0, 1)
                }, 300)
            }
        },

        removeAllNotifications(state) {
            for (const [index] of state.notifications) {
                state.notifications[index].show = false

                setTimeout(() => {
                    state.modals.splice(0, 1)
                }, 300)
            }
        },

        removeModal(state, identifier) {
            const index = identifier
                ? state.modals.findIndex(modal => modal.identifier === identifier)
                : 0

            if (index !== -1) {
                state.modals[index].show = false

                setTimeout(() => {
                    state.modals.splice(index, 1)
                }, 300)
            }
        },

        removeNotification(state, identifier) {
            const index = state.notifications.findIndex(notification => notification.identifier === identifier)

            if (index !== -1) {
                state.notifications[index].show = false

                setTimeout(() => {
                    state.notifications.splice(index, 1)
                }, 300)
            }
        },
    },

    getters: {
        modals(state) {
            return state.modals
        },

        notifications(state) {
            return state.notifications
        }
    },

    actions: {
        addPopup({commit}, content) {
            const data = content.data

            switch (data.type) {
                case 'notification':
                    commit('addNotification', content)

                    if (!data.stayable) {
                        const displayTime = data.time || app.$config.notification.displayTime

                        setTimeout(() => {
                            commit('removeNotification', content.identifier)
                        }, displayTime);
                    }

                    break
                case 'modal':
                    commit('addModal', content)

                    break
            }
        },

        addNotification({dispatch}, {message, type = 'error'}) {
            dispatch('addPopup',
                {
                    type: "notification",
                    identifier: uuidGenerator(),
                    component: "SimpleNotification",
                    attributes: {
                        type: type,
                    },
                    content: {
                        text: message
                    },
                    data: {
                        stayable: false,
                    }
                },
            )
        }
    },
}
