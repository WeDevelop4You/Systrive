<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewProperties from "../../mixins/ViewProperties";

    export default {
        name: "Settings",

        mixins: [
            ViewProperties
        ],

        beforeRouteUpdate(to, from, next) {
            this.setup(to.params.page)

            next()
        },

        created() {
            this.setup(this.$route.params.page)
        },

        methods: {
            getRoute() {
                return this.$api.route('account.settings.overview')
            },

            setup(page) {
                this.$store.dispatch(
                    'user/auth/settings/page/component',
                    this.$api.route('account.settings.overview.page', page)
                )
            },
        }
    }
</script>
