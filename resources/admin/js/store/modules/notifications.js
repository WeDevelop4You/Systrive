import Vue from 'vue';
import { v4 as uuidGenerator } from 'uuid';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        popups: []
    }),

    mutations: {
        addPopup(state, popup) {
            state.popups.push(popup)
        },

        removePopup(state, uuid) {
            const index = state.popups.findIndex(popup => popup.uuid === uuid)

            state.popups.splice(index, 1)
        }
    },

    getters: {
        popups(state) {
            return state.popups
        }
    },

    actions: {
        popup({commit}, popup) {
            const uuid = uuidGenerator()

            popup.uuid = uuid
            commit('addPopup', popup)

            if (!popup.stayable) {
                const displayTime = popup.time || app.$config.popup.displayTime

                setTimeout(() => {
                    commit('removePopup', uuid)
                }, displayTime);
            }
        }
    },
}
