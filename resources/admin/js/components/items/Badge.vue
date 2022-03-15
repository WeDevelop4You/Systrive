<template>
    <v-chip
        :color="color"
        :outlined="outlined"
        label
        small
        link
    >
        <slot name="prepend" />
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
            },

            outlined: {
                type: Boolean,
                default: false,
            }
        }
    }
</script>
