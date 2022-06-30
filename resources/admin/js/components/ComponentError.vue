<template>
    <v-row class="ma-6">
        <v-col
            cols="12"
            class="text-center"
        >
            <v-icon
                color="error"
                size="50"
            >
                fas fa-exclamation-triangle
            </v-icon>
        </v-col>
        <v-col
            cols="12"
            class="text-center"
        >
            <p>{{ $vuetify.lang.t('$vuetify.text.component.error') }}</p>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "ComponentError"
    }
</script>
