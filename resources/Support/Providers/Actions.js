export default class Actions
{
    #actions = new Map()

    constructor(store, router) {
        this.#setDefault(store, router)
    }

    add(name, callback) {
        this.#actions.set(name, callback)
    }

    call(action) {
        if (action) {
            if (this.#actions.has(action?.name)) {
                const callback = this.#actions.get(action.name)
                const promise = callback.call(this, (action.data ?? {}))

                if (this.#returnIsPromise(promise)) {
                    return promise.then(() => {
                        return this.call(action.successAction)
                    }).catch(() => {
                        return this.call(action.failAction)
                    })
                }

                return this.call(action.successAction)
            }

            console.error('undefined action', action)
        }

        return undefined;
    }

    #returnIsPromise(func = null) {
        return !(!func || func.constructor.name === 'AsyncFunction' || (typeof func === 'function' && this.#isPromise(func())));
    }

    #isPromise(promise) {
        return typeof promise === 'object' && typeof promise.then === 'function';
    }

    #setDefault(store, router) {
        this.add(
            'noAction',
            () => {}
        )
        this.add(
            'chainAction',
            async (actions) => {
                for (const action of actions) {
                    await this.call(action)
                }
            }
        )
        this.add(
            'vuexCommitMethodAction',
            ({type, params}) => {
                return store.commit(type, params)
            }
        )
        this.add(
            'vuexDispatchMethodAction',
            ({type, params}) => {
                return store.dispatch(type, params)
            }
        )

        if (router !== undefined) {
            this.add(
                'goToRouteAction',
                ({route}) => {
                    return router.push(route)
                }
            )
        }
    }
}
