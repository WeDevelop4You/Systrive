<template>
    <router-view />
</template>

<script>
    export default {
        name: "Company",

        async beforeCreate() {
            await this.$store.dispatch('user/companies/search', [this.$route.params.companyName, true])
        },

        beforeDestroy() {
            this.$store.dispatch('navigation/getCompanies', true)
        }
    }
</script>
