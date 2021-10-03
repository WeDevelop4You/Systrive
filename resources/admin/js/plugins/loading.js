export default {
    install(Vue) {
        Vue.mixin({
            data() {
                return {
                    requests: 0
                }
            },

            created() {
                let app = this;

                this.$api.call.interceptors.request.use(function (config) {
                    app.requests++
                    return config
                }, function (error) {
                    app.requests--
                    return Promise.reject(error)
                });

                this.$api.call.interceptors.response.use(function (response) {
                    app.requests--
                    return response
                }, function (error) {
                    app.requests--
                    return Promise.reject(error)
                });
            },

            computed: {
                $loading() {
                    return !!this.requests
                },
            }
        })
    }
}
