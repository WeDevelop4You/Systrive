<template>
    <view-layer :value="overview" />
</template>

<script>
import ViewProperties from "../../mixins/ViewProperties";

export default {
    name: "Companies",

    mixins: [
        ViewProperties
    ],

    created() {
        this.$store.commit('company/users/form/setType', 'user')
        this.$store.commit('company/roles/form/setType', 'role')
    },

    beforeDestroy() {
        this.$store.commit('company/users/form/resetParameters')
        this.$store.commit('company/roles/form/resetParameters')
    },

    methods: {
        getRoute() {
            return this.$api.route('admin.company.overview')
        }
    }
}
</script>
