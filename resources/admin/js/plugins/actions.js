export default {
    install(Vue) {
        Vue.mixin({
            methods: {
                callAction(data) {
                    if (Object.prototype.hasOwnProperty.call(data, 'action')) {
                        this[data.action.method](...data.action.parameters ?? [])
                    }
                },

                async actionGoToRoute(route) {
                    await this.$router.push(route).catch(() => {})
                },

                async actionGoToLastRoute() {
                    const originLastRoute = this.$root.lastRoute

                    await this.actionGoToRoute(originLastRoute)

                    this.$root.lastRoute = originLastRoute
                },

                async actionGoToMainRoute() {
                    const originLastRoute = this.$root.lastRoute

                    await this.actionGoToRoute({name: this.$route.name})

                    this.$root.lastRoute = originLastRoute
                },
            }
        })
    }
}
