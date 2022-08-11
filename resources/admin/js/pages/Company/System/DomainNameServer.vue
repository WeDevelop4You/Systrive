<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewLayer from "../../../components/Overviews/Page.vue";

    export default {
        name: "DomainNameServer",

        components: {
            ViewLayer,
        },

        beforeRouteUpdate(to, from, next) {
            this.setup(to.params.domainNameServer)

            next()
        },

        data() {
            return {
                overview: {
                    data: {
                        vuexNamespace: 'company/system/dns/overview'
                    }
                }
            }
        },

        created() {
            this.setup(this.$route.params.domainNameServer)
        },

        methods: {
            async setup(dns) {
                await this.$store.dispatch('company/system/dns/search', dns)
            }
        }
    }
</script>
