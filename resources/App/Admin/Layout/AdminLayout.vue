<template>
    <main-layout />
</template>

<script>
    import MainLayout from "../../../Support/Layout/MainLayout.vue";

    export default {
        name: "Admin",

        components: {
            MainLayout,
        },

        props: {
            response: {
                required: true,
                type: Array
            },
        },

        created() {
            this.response.forEach((data) => {
                this.$responseChain(data)
            })

            this.$auth.load();

            this.$store.dispatch('navigation/sub')
            this.$store.dispatch('navigation/main', this.$api.route('admin.navigation'))
        }
    }
</script>
