<template>
    <router-view v-if="$store.state.user.hasCompanyPermission" />
</template>

<script>
    export default {
        name: "Company",

        async beforeCreate() {
            await this.$store.dispatch('company/search', [this.$route.params.companyName, true])
            await this.$store.dispatch('user/getCompanyPermissions')
        },

        beforeDestroy() {
            this.$store.dispatch('navigation/getCompanies', true)
            this.$store.dispatch('user/getPermissions')
        }
    }
</script>
