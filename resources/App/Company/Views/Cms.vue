<template>
    <router-view v-if="isLoaded" />
</template>

<script>
    export default {
        name: "Cms",

        beforeRouteUpdate(to, from, next) {
            if (to.params.cmsName !== from.params.cmsName) {
                this.load(to.params.cmsName)
            }

            next()
        },

        data() {
            return {
                isLoaded: false
            }
        },

        created() {
            this.load(this.$route.params.cmsName)
        },

        methods: {
            load(cms) {
                this.isLoaded = false

                this.$store.dispatch('cms/search', cms).then(() => {
                    this.isLoaded = true
                })
            }
        }
    }
</script>
