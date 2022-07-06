<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewLayer from "../../../components/Overviews/Page";

    export default {
        name: "Domain",

        components: {
            ViewLayer,
        },

        beforeRouteUpdate(to, from, next) {
            this.setup(to.params.domainName)

            next()
        },

        data() {
            return {
                overview: {
                    data: {
                        vuexNamespace: 'company/system/domain/overview'
                    }
                }
            }
        },

        created() {
            this.setup(this.$route.params.domainName)
        },

        methods: {
            setup(domain) {
                this.$store.dispatch('company/system/domain/search', domain)
            },
        },
    }
</script>
