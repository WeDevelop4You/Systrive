<template>
    <roles-table />
</template>

<script>
    import rolesTable from "../../../layout/tables/Roles"

    export default {
        name: "Roles",

        components: {
            rolesTable,
        },

        created() {
            this.$store.dispatch('permissions/getList')
        }
    }
</script>
