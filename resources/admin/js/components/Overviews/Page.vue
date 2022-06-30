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
                timeout: 5000
            }),
            Card: () => ({
                component: import(/* webpackChunkName: "components/overviews/card" */ '../Overviews/Card'),
                loading: SkeletonCard,
                delay: 0,
                error: ComponentError,
                timeout: 5000
            }),
        },

        mixins: [
            ComponentProperties
        ],

        data() {
            return {
                component: {},
                route: this.value.data.route,
                vuexNamespace: this.value.data.vuexNamespace,
                reload: this.value.data.reload,
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
            if (this.route !== undefined) {
                this.load()
            }

            if (this.reload) {
                this.interval = setInterval(() => {
                    this.load()
                }, this.reload)
            }
        },

        beforeDestroy() {
            if (this.reload) {
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
