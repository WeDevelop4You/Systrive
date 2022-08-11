<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewLayer from "../../../components/Overviews/Page.vue";

    export default {
        name: "Database",

        components: {
            ViewLayer,
        },

        beforeRouteUpdate(to, from, next) {
            this.setup(to.params.databaseName)

            next()
        },

        data() {
            return {
                overview: {
                    data: {
                        vuexNamespace: 'company/system/database/overview'
                    }
                }
            }
        },

        created() {
            this.setup(this.$route.params.databaseName)
        },

        methods: {
            setup(database) {
                this.$store.dispatch('company/system/database/search', database)
            }
        }
    }
</script>
