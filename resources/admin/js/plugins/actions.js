export default {
    install(Vue) {
        Vue.mixin({
            methods: {
                callAction(action) {
                    return this[action.method](action.data ?? {})
                },

                actionGoToRoute({route}) {
                    return this.$router.push(route)
                },

                actionGoToLastRoute() {
                    const originLastRoute = this.$root.lastRoute

                    const promise = this.actionGoToRoute({route: originLastRoute})

                    this.$root.lastRoute = originLastRoute

                    return promise
                },

                actionGoToMainRoute() {
                    const originLastRoute = this.$root.lastRoute

                    const promise = this.actionGoToRoute({route: {name: this.$route.name}})

                    this.$root.lastRoute = originLastRoute

                    return promise
                },

                actionRequest({url, method, params}) {
                    return this.$api.call({
                        url: url,
                        method: method,
                        data: params
                    })
                },

                actionVuexCommitMethod({type, params}) {
                    return this.$store.commit(type, params)
                },

                actionVuexDispatchMethod({type, params}) {
                    return this.$store.dispatch(type, params)
                },
            }
        })
    }
}
