<template>
    <router-view v-if="$store.getters['user/permissions/getType'] === $config.permissions.types.company" />
</template>

<script>
    export default {
        name: "Company",

        async beforeCreate() {
            await this.$store.dispatch('company/search', this.$route.params.companyName)
            await this.$store.dispatch('user/permissions/getCompany')
        },

        beforeDestroy() {
            this.$store.dispatch('navigation/getCompanies')
            this.$store.dispatch('user/permissions/getDefault')
        }
    }
</script>
