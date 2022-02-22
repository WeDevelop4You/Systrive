<template>
    <v-chip
        :color="color"
        small
    >
        {{ value }}
    </v-chip>
</template>

<script>
    export default {
        name: "Badge",

        props: {
            value: {
                required: true,
                type: String
            },

            color: {
                type: String,
                default: ''
            }
        }
    }
</script>
