<template>
    <view-layer :value="overview" />
</template>

<script>
    import ViewProperties from "../../../mixins/ViewProperties";

    export default {
        name: "Users",

        mixins: [
            ViewProperties
        ],

        created() {
            this.$store.dispatch('permissions/getList')
            this.$store.dispatch('company/roles/dropList')
        },

        methods: {
            getRoute() {
                const id = this.$store.getters['company/id']

                return this.$api.route('company.user.overview', id)
            }
        }
    }
</script>
