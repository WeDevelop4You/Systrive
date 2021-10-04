import store from '../store'

export default {
    install(Vue) {
        Vue.prototype.$auth = {
            user() {
                return store.getters['user/get']
            },

            hasPermission(...permissions) {

            }
        }
    }
}
