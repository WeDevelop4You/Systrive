import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        popups: []
    }),

    mutations: {
        addPopup(state, popup) {
            const index = state.popups.push(popup) -1
            const displayTime = popup.time || app.$config.popup.displayTime

            setTimeout(() => {state.popups.splice(index, 1)}, displayTime);
        }
    },

    getters: {
        popups(state) {
            return state.popups
        }
    },

    actions: {

    },
}
