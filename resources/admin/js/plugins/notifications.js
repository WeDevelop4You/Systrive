import store from '../store'

export default {
    install(Vue) {
        let app = Vue.prototype

        function addPopup(data) {
            if (data.hasOwnProperty('popup')) {
                store.dispatch('notifications/popup', data.popup);
            }
        }

        app.$api.call.interceptors.response.use(function (response) {
            addPopup(response.data)

            return response;
        }, function (error) {
            addPopup(error.response.data)

            return Promise.reject(error)
        })
    }
}
