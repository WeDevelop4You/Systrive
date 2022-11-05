import Import from "../helpers/Import";
import Breadcrumb from "../helpers/Breadcrumb";

const app = Import.app()
const $api = Import.api()
const $store = Import.store()
const $router = Import.router()

export default class Actions
{
    call(action) {
        if (action) {
            if (action.method !== 'noAction') {
                const promise = this[action.method](action.data ?? {})

                if (this.returnIsPromise(promise)) {
                    return promise.then(() => {
                        return this.call(action.successAction)
                    }).catch(() => {
                        return this.call(action.failAction)
                    })
                }
            }

            return this.call(action.successAction)
        }

        return undefined
    }

    async chainAction(actions) {
        for (const action of actions) {
            await this.call(action)
        }
    }

    goToRouteAction({route}) {
        return $router.push(route)
    }

    requestAction({url, method, params}) {
        return $api.call({
            url: url,
            method: method,
            data: params
        })
    }

    vuexCommitMethodAction({type, params}) {
        return $store.commit(type, params)
    }

    vuexDispatchMethodAction({type, params}) {
        return $store.dispatch(type, params)
    }

    breadcrumbsAddAction(items) {
        this.breadcrumbsRemoveAction()

        items.forEach((item) => {
            app.$breadcrumbs.add(new Breadcrumb(
                item.label,
                item.to,
                item.additional
            ))
        })
    }

    breadcrumbsRemoveAction() {
        app.$breadcrumbs.remove()
    }

    returnIsPromise(func = null) {
        return !(!func || func.constructor.name === 'AsyncFunction' || (typeof func === 'function' && this.#isPromise(func())));
    }

    #isPromise(promise) {
        return typeof promise === 'object' && typeof promise.then === 'function';
    }
}
