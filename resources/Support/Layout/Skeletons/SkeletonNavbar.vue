<template>
    <v-skeleton-loader
        id="navbar"
        :type="isHidden ? 'avatar@3, divider, avatar@3' : 'heading, list-item-avatar@3, divider, heading, list-item-avatar@3'"
    />
</template>

<script>
    export default {
        name: "SkeletonNavbar",

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
