import Vue from 'vue';
import { v4 as uuidGenerator } from 'uuid';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        modal: {},
        notifications: []
    }),

    mutations: {
        setModal(state, data) {
            state.modal = data
        },

        addNotifications(state, data) {
            state.notifications.push(data)
        },

        removeNotifications(state, uuid) {
            const index = state.notifications.findIndex(notification => notification.uuid === uuid)

            state.notifications.splice(index, 1)
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
            let data = content.data
            const type = content.type

            if (type === 'notification') {
                const uuid = uuidGenerator()

                data.uuid = uuid
                commit('addNotifications', content)

                if (!data.stayable) {
                    const displayTime = data.time || app.$config.notification.displayTime

                    setTimeout(() => {
                        commit('removeNotifications', uuid)
                    }, displayTime);
                }
            } else if (type === 'modal') {
                content.show = true

                commit('setModal', content)
            }
        },

        addNotification({dispatch}, {message, type = 'error'}) {
            dispatch(
                'addPopup',
                {
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
