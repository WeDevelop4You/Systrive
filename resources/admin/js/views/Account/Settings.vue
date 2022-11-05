<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewBase from "../Base/ViewBase";

    export default {
        name: "Settings",

        extends: ViewBase,

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
