<template>
    <v-btn
        :disabled="$loading"
        small
        color="primary"
        @click="$emit('click')"
    >
        {{ content }}
    </v-btn>
</template>

<script>
    export default {
        name: "DefaultButton",

        props: {
            content: {
                required: true,
                type: String
            }
        }
    }
</script>
