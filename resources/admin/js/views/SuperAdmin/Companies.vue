<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewBase from "../Base/ViewBase";

    export default {
        name: "Companies",

        extends: ViewBase,

        created() {
            this.$store.commit('company/users/form/setType', 'user')
            this.$store.commit('company/roles/form/setType', 'role')
            this.$store.commit('company/cms/form/setType', 'cms')
        },

        beforeDestroy() {
            this.$store.commit('company/users/form/resetParameters')
            this.$store.commit('company/roles/form/resetParameters')
            this.$store.commit('company/cms/form/resetParameters')
        },

        methods: {
            getRoute() {
                return this.$api.route('admin.company.overview')
            }
        }
    }
</script>
