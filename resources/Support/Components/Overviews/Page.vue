<template>
    <div>
        <template v-if="!isLoad">
            <ComponentLoading />
        </template>
        <component
            :is="overview.componentName"
            v-bind="overview.attributes"
            v-else
            :value="overview"
        />
    </div>
</template>

<script>
    import ComponentError from "../ComponentError.vue";
    import ComponentLoading from "../ComponentLoading.vue";
    import Component from "../../Helpers/Components/Component";
    import ComponentList from "../../Mixins/ComponentList";
    import Loader from "../../Providers/Loader";

    export default {
        name: "Page",

        components: {
            ComponentError,
            ComponentLoading,
        },

        mixins: [
            ComponentList
        ],

        beforeRouteUpdate(to, from, next) {
            if (this.hasUpdateOnRouteChange && this.getUpdateOnRouteChangeCondition(to, from)) {
                this.component = Component.empty()

                this.getComponent(to)
            }

            next()
        },

        props: {
            value: {
                type: Object,
                default: () => {
                    return {data: {}}
                }
            }
        },

        data() {
            return {
                component: {},
                route: this.value.data.route,
                loadState: this.value.data.loadState,
                vuexNamespace: this.value.data.vuexNamespace,
                refreshDelay: this.value.data.refreshDelay,
                updateOnRouteChange: this.value.data.updateOnRouteChange
            }
        },

        computed: {
            isLoad() {
                return Object.keys(this.overview).length !== 0
            },

            overview() {
                if (this.hasVuexNamespace()) {
                    return this.$store.getters[`${this.vuexNamespace}/component`]
                }

                return this.component
            }
        },

        created() {
            if (this.$loader instanceof Loader) {
                this.$loader.convertStringToRouteParams()
            }

            if (this.hasRoute()) {
                this.getComponent()
            }

            if (this.hasRefreshDelay()) {
                this.createRefresh()
            }

            if (this.hasLoadState()) {
                this.runLoadState()
            }
        },

        beforeDestroy() {
            if (this.hasRefreshDelay()) {
                clearInterval(this.interval)
            }
        },

        methods: {
            hasRoute() {
                return this.route !== undefined
            },

            hasVuexNamespace() {
                return this.vuexNamespace !== undefined
            },

            hasRefreshDelay() {
                return this.refreshDelay !== undefined
            },

            hasLoadState() {
                return this.loadState !== undefined
            },

            hasUpdateOnRouteChange() {
                return this.updateOnRouteChange !== undefined
            },

            createRoute(to) {
                return this.route instanceof Function
                    ? this.route.call(this, {app: this, route: to || this.$route})
                    : this.route
            },

            createRefresh() {
                this.interval = setInterval(() => {
                    this.getComponent()
                }, this.refreshDelay)
            },

            getComponent(to) {
                const route = this.createRoute(to)

                this.hasVuexNamespace() ? this.getComponentWithVuex(route) : this.getComponentWithApi(route)
            },

            getComponentWithVuex(route) {
                this.$store.dispatch(`${this.vuexNamespace}/component`, route)
            },

            getComponentWithApi(route) {
                const errorComponent = new Component({
                    componentName: 'ComponentError'
                })

                this.$api.call({
                    url: route,
                    method: "GET"
                }).then((response) => {
                    this.component = response.data.component || errorComponent
                })
            },

            getLoadStateVuexNamespace() {
                switch (typeof this.loadState) {
                    case "boolean":
                        return ''
                    case "string":
                        return this.loadState
                    default:
                        return this.vuexNamespace
                }
            },

            getUpdateOnRouteChangeCondition(to, from) {
                return this.updateOnRouteChange instanceof Function
                    ? this.updateOnRouteChange.call(this, to, from)
                    : this.updateOnRouteChange
            },

            runLoadState() {
                const vuexNamespace = this.getLoadStateVuexNamespace()

                if (vuexNamespace !== undefined) {
                    this.$loader.runStateAction(vuexNamespace)
                }
            }
        }
    }
</script>
