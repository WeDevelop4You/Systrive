<template>
    <router-view :key="$route.name" />
</template>

<script>
    export default {
        name: "Auth",

        props: {
            response: {
                required: true,
                type: Array
            }
        },

        created() {
            this.$vuetify.theme.dark = true

            this.response.forEach((data) => {
                this.$responseChain(data)
            })
        },
    }
</script>
