export default {
    install(Vue) {
        Vue.prototype.$config = {
            elevation: 3,

            popup: {
                displayTime: 1000 * 10
            }
        }
    }
}
