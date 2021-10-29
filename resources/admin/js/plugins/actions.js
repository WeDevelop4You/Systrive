export default {
    install(Vue) {
        Vue.mixin({
            methods: {
                callAction(data) {
                    if (Object.prototype.hasOwnProperty.call(data, 'action')) {
                        this[data.action.method](...data.action.parameters ?? [])
                    }
                },

                actionGoToRoute(route) {
                    this.$router.push(route)
                },

                actionGoToLastRoute() {
                    this.actionGoToRoute(this.$root.lastRoute)
                },
            }
        })
    }
}
