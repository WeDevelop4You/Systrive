<template>
    <router-view />
</template>

<script>
    export default {
        name: "Company",

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

            this.$auth.load()

            this.$store.dispatch('navigation/sub')
        }
    }
</script>
