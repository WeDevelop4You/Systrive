<template>
    <v-chip
        :color="item.status.color"
        small
    >
        {{ item.status.text }}
    </v-chip>
</template>

<script>
    export default {
        name: "Status",

        props: {
            item: {
                required: true,
                type: Object
            },

            isMobile: {
                required: true,
                type: Boolean
            },

            header: {
                required: true,
                type: Object
            },

            index: {
                required: true,
                type: Number
            }
        },
    }
</script>
