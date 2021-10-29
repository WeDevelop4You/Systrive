<template>
    <router-view />
</template>

<script>
    export default {
        name: "Company",

        async activated() {
            await this.$store.dispatch('user/companies/search', [this.$route.params.companyName, true])
        },

        deactivated() {
            this.$store.dispatch('navigation/getCompanies', true)
        }
    }
</script>
