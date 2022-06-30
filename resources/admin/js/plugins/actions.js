export default {
    install(Vue) {
        Vue.mixin({
            methods: {
                callAction(action) {
                    if (action) {
                        const promise = this[`_${action.method}`](action.data ?? {})

                        if (this._returnIsPromise(promise)) {
                            promise.then(() => {
                                this.callAction(action.onSuccess)
                            }).catch(() => {})

                            return promise
                        }

                        return this.callAction(action.onSuccess)
                    }
                },

                async _actionChain(actions) {
                    for (const action of actions) {
                        await this.callAction(action)
                    }
                },

                _actionClosePopupModal({identifier}) {
                    this.$store.commit('popups/removeModal', identifier)
                },

                _actionGoToRoute({route}) {
                    return this.$router.push(route)
                },

                _actionRequest({url, method, params}) {
                    return this.$api.call({
                        url: url,
                        method: method,
                        data: params
                    })
                },

                _actionVuexCommitMethod({type, params}) {
                    return this.$store.commit(type, params)
                },

                _actionVuexDispatchMethod({type, params}) {
                    return this.$store.dispatch(type, params)
                },

                _actionBreadcrumbsAdd(breadCrumbs) {
                    this._actionBreadcrumbsRemove()

                    this.$route.meta.breadcrumbs.push(...breadCrumbs)
                },

                _actionBreadcrumbsRemove() {
                    const breadCrumbs = this.$route.meta.breadcrumbs
                    const index = breadCrumbs.findIndex(
                        (x) => Object.prototype.hasOwnProperty.call(x, 'added')
                    )

                    if (index > -1) {
                        breadCrumbs.splice(index, breadCrumbs.length - index)
                    }
                },

                _returnIsPromise(func = null) {
                    return !(!func || func.constructor.name === 'AsyncFunction' || (typeof func === 'function' && this._isPromise(func())));
                },

                _isPromise(promise) {
                    return typeof promise === 'object' && typeof promise.then === 'function';
                },
            }
        })
    }
}
