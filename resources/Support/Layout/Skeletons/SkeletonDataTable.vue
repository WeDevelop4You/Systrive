<template>
    <v-skeleton-loader
        :elevation="$config.elevation"
        type="table"
        class="rounded-lg"
    />
</template>

<script>
    export default {
        name: "SkeletonDataTable"
    }
</script>
