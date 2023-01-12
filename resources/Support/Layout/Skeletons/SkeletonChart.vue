<template>
    <v-skeleton-loader
        :elevation="$config.elevation"
        type="image"
        class="rounded-lg"
    />
</template>

<script>
    export default {
        name: "SkeletonChart",
    }
</script>
