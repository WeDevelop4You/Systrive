<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewProperties from "../../../mixins/ViewProperties";

    export default {
        name: "Roles",

        mixins: [
            ViewProperties
        ],

        methods: {
            getRoute() {
                const id = this.$store.getters['company/id']

                return this.$api.route('company.role.overview', id)
            }
        }
    }
</script>
