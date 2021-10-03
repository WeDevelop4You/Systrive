import store from '../store'

export default {
    install(Vue) {
        store.dispatch('user/get')

        Vue.prototype.$auth = {
            user() {
                return store.getters['user/get']
            },

            hasPermission(...permissions) {

            }
        }
    }
}
