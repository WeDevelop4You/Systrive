<template>
    <user-access />
</template>

<script>
    import UserAccess from "../../../layout/tables/UserAccess";

    export default {
        name: "Users",

        components: {
            UserAccess
        },

        created() {
            this.$store.dispatch('permissions/getList')
        }
    }
</script>
