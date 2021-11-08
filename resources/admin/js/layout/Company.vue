<template>
    <router-view />
</template>

<script>
    export default {
        name: "Company",

        async beforeCreate() {
            await this.$store.dispatch('company/search', [this.$route.params.companyName, true])
        },

        beforeDestroy() {
            this.$store.dispatch('navigation/getCompanies', true)
        }
    }
</script>
