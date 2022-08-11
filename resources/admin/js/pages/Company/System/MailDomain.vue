<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewLayer from "../../../components/Overviews/Page.vue";

    export default {
        name: "MailDomain",

        components: {
            ViewLayer
        },

        beforeRouteUpdate(to, from, next) {
            this.setup(to.params.mailDomainName)

            next()
        },

        data() {
            return {
                overview: {
                    data: {
                        vuexNamespace: 'company/system/mailDomain/overview'
                    }
                }
            }
        },

        created() {
            this.setup(this.$route.params.mailDomainName)
        },

        methods: {
            setup(mailDomain) {
                this.$store.dispatch('company/system/mailDomain/search', mailDomain)
            }
        }
    }
</script>
