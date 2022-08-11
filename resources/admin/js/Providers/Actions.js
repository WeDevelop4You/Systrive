import Helper from "./Helper";

export default class Actions
{
    #api = Helper.getApi()
    #store = Helper.getStore()
    #router = Helper.getRouter()

    call(action) {
        if (action) {
            const promise = this[action.method](action.data ?? {})

            if (this.returnIsPromise(promise)) {
                return promise.then(() => {
                    return this.call(action.onSuccess)
                }).catch(() => {
                    return Promise.resolve()
                })
            }

            return this.call(action.onSuccess)
        }

        return undefined
    }

    async actionChain(actions) {
        for (const action of actions) {
            await this.call(action)
        }
    }

    actionClosePopupModal({identifier}) {
        this.#store.commit('popups/removeModal', identifier)
    }

    actionGoToRoute({route}) {
        return this.#router.push(route)
    }

    actionRequest({url, method, params}) {
        return this.#api.call({
            url: url,
            method: method,
            data: params
        })
    }

    actionVuexCommitMethod({type, params}) {
        return this.#store.commit(type, params)
    }

    actionVuexDispatchMethod({type, params}) {
        return this.#store.dispatch(type, params)
    }

    actionBreadcrumbsAdd(breadCrumbs) {
        this.actionBreadcrumbsRemove()

        this.#router.currentRoute.meta.breadcrumbs.push(...breadCrumbs)
    }

    actionBreadcrumbsRemove() {
        const breadCrumbs = this.#router.currentRoute.meta.breadcrumbs
        const index = breadCrumbs.findIndex(
            (x) => Object.prototype.hasOwnProperty.call(x, 'added')
        )

        if (index > -1) {
            breadCrumbs.splice(index, breadCrumbs.length - index)
        }
    }

    returnIsPromise(func = null) {
        return !(!func || func.constructor.name === 'AsyncFunction' || (typeof func === 'function' && this.#isPromise(func())));
    }

    #isPromise(promise) {
        return typeof promise === 'object' && typeof promise.then === 'function';
    }
}
