<template>
    <div>
        <template v-if="!isLoad">
            <ComponentLoading />
        </template>
        <component
            :is="overview.componentName"
            v-else
            :value="overview"
        />
    </div>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import LazyImportProperties from "../../mixins/LazyImportProperties";
    import ComponentLoading from "../ComponentLoading";
    import SkeletonCard from "../../layout/Skeletons/SkeletonCard";
    import ComponentError from "../ComponentError";
    import SkeletonDataTable from "../../layout/Skeletons/SkeletonDataTable";

    export default {
        name: "Page",

        components: {
            ComponentLoading,

            Row: () => ({
                component: import(/* webpackChunkName: "components/layouts/row" */ "../Layouts/Row"),
                ...LazyImportProperties
            }),
            Table: () => ({
                component: import(/* webpackChunkName: "components/overviews/table" */ "./Table"),
                loading: SkeletonDataTable,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
            Card: () => ({
                component: import(/* webpackChunkName: "components/overviews/card" */ '../Overviews/Card'),
                loading: SkeletonCard,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
        },

        mixins: [
            ComponentProperties
        ],

        data() {
            return {
                component: {},
                route: this.value.data.route,
                runLoader: this.value.data.runLoader,
                vuexNamespace: this.value.data.vuexNamespace,
                callbackDelay: this.value.data.callbackDelay,
                hasVuexNamespace: this.value.data.vuexNamespace !== undefined,
                hasCallbackDelay: this.value.data.callbackDelay !== undefined,
            }
        },

        computed: {
            isLoad() {
                return Object.keys(this.overview).length !== 0
            },

            overview() {
                if (this.vuexNamespace !== undefined) {
                    return this.$store.getters[`${this.vuexNamespace}/component`]
                }

                return this.component
            }
        },

        created() {
            this.$loader.convertStringToRouteParams()

            if (this.route !== undefined) {
                this.load()
            }

            if (this.hasCallbackDelay) {
                this.interval = setInterval(() => {
                    this.load()
                }, this.callbackDelay)
            }

            if (this.runLoader !== undefined) {
                const vuexNamespace = typeof this.runLoader === 'string'
                    ? this.runLoader
                    : this.vuexNamespace

                if (vuexNamespace !== undefined) {
                    this.$loader.runStateAction(vuexNamespace)
                }
            }
        },

        beforeDestroy() {
            if (this.hasCallbackDelay) {
                clearInterval(this.interval)
            }
        },

        methods: {
            load() {
                if (this.vuexNamespace !== undefined) {
                    this.$store.dispatch(`${this.vuexNamespace}/component`, this.route)
                } else {
                    this.$api.call({
                        url: this.route
                    }).then((response) => {
                        this.component = response.data.component || {}
                    })
                }
            }
        }
    }
</script>
