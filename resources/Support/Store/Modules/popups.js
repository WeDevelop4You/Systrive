import DialogComponent from "../../Helpers/Components/DialogComponent";
import NotificationComponent from "../../Helpers/Components/NotificationComponent";
import {cloneDeep as _cloneDeep} from 'lodash'

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
            for (const modal of state.modals) {
                modal.data.show = false

                setTimeout(() => {
                    state.modals.splice(0, 1)
                }, 1000)
            }
        },

        removeAllNotifications(state) {
            for (const notification of state.notifications) {
                notification.data.show = false

                setTimeout(() => {
                    state.modals.splice(0, 1)
                }, 1000)
            }
        },

        removeModal(state, identifier) {
            const index = identifier
                ? state.modals.findIndex(modal => modal.identifier === identifier)
                : 0

            if (index !== -1 && state.modals) {
                state.modals[index].data.show = false

                setTimeout(() => {
                    state.modals.splice(index, 1)
                }, 1000)
            }
        },

        removeNotification(state, identifier) {
            const index = state.notifications.findIndex(notification => notification.identifier === identifier)

            if (index !== -1 && state.notifications) {
                state.notifications[index].data.show = false

                setTimeout(() => {
                    state.notifications.splice(index, 1)
                }, 1000)
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
        addPopup({commit}, popup) {
            switch (popup.constructor) {
                case NotificationComponent:
                    commit('addNotification', popup)

                    if (!popup.data.stayable) {
                        setTimeout(() => {
                            commit('removeNotification', popup.identifier)
                        }, popup.data.displayTime);
                    }

                    break
                case DialogComponent:
                    commit('addModal', popup)

                    break
            }
        },

        addDialog({dispatch}, component) {
            dispatch('addPopup', new DialogComponent(_cloneDeep(component)))
        }
    },
}
