<template>
    <v-btn
        :disabled="$loading"
        icon
        @click="$emit('close')"
    >
        <v-icon>fas fa-times</v-icon>
    </v-btn>
</template>

<script>
    export default {
        name: "CloseButton",
    }
</script>
