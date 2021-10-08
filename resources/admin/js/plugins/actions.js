export default {
    install(Vue) {
        Vue.mixin({
            data() {
                return {
                    lastRoute: '/',
                }
            },

            methods: {
                callAction(data) {
                    if (data.hasOwnProperty('action')) {
                        this[data.action.method](...data.action.parameters ?? [])
                    }
                },

                actionGoToRoute(route) {
                    this.$router.push(route)
                },

                actionGoToLastRoute(routePath) {
                    this.actionGoToRoute(routePath ?? this.lastRoute)
                },
            }
        })
    }
}
