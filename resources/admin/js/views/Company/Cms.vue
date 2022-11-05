<template>
    <router-view v-if="isLoaded"/>
</template>

<script>
    export default {
        name: "Cms",

        data() {
            return {
                isLoaded: false
            }
        },

        beforeRouteUpdate(to, from, next) {
            if (to.params.cmsName !== from.params.cmsName) {
                this.load(to.params.cmsName)
            }

            next()
        },

        created() {
            this.load(this.$route.params.cmsName)
        },

        methods: {
            load(cms) {
                this.isLoaded = false

                this.$store.dispatch('company/cms/search', cms).then(() => {
                    this.isLoaded = true
                })
            }
        }
    }
</script>
