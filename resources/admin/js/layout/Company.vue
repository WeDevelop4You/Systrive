<template>
    <router-view></router-view>
</template>

<script>
    export default {
        name: "Company",

        async activated() {
            await this.$store.dispatch('navigation/getCompanies', this.$route.params.companyName)
        },

        deactivated() {
            this.$store.dispatch('navigation/getCompanies', true)
        }
    }
</script>
