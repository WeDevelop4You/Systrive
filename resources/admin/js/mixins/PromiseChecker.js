export default {
    methods: {
        returnIsPromise(func = null) {
            return !(!func || func.constructor.name === 'AsyncFunction' || (typeof func === 'function' && this.isPromise(func())));
        },

        isPromise(promise) {
            return typeof promise === 'object' && typeof promise.then === 'function';
        },
    }
}
