<template>
    <Badge
        v-model="value.content"
        :color="value.is_active ? 'success' : 'error'"
        outlined
        class="my-1"
        style="max-width: max-content"
    />
</template>

<script>
    import Badge from "./Badge";

    export default {
        name: "Active",

        components: {
            Badge
        },

        props: {
            value: {
                required: true,
                type: Object
            }
        }
    }
</script>
