<template>
    <router-view v-if="$store.getters['user/getPermissionType'] === $config.permissions.types.company" />
</template>

<script>
    export default {
        name: "Company",

        async beforeCreate() {
            await this.$store.dispatch('company/search', this.$route.params.companyName)
            await this.$store.dispatch('user/getCompanyPermissions')
        },

        beforeDestroy() {
            this.$store.dispatch('user/getPermissions')
            this.$store.dispatch('navigation/getCompanies')
        }
    }
</script>
