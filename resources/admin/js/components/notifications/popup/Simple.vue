<template>
    <v-alert border="left" colored-border :type="message.type" :elevation="$config.elevation">
        <div v-html="message.text"></div>
    </v-alert>
</template>

<script>
    export default {
        name: "Simple",

        props: {
            message: {
                type: Object,
                required: true
            },
        }
    }
</script>
