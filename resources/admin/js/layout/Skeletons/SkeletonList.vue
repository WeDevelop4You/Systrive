<template>
    <v-skeleton-loader
        :elevation="$config.elevation"
        type="list-item, list-item-two-line@2, divider, list-item, list-item-two-line"
        class="rounded-lg"
    />
</template>

<script>
    export default {
        name: "SkeletonList"
    }
</script>
