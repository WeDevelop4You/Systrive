<template>
    <v-row :class="[small ? '' : 'ma-6']">
        <v-col
            cols="12"
            class="text-center"
        >
            <v-icon
                color="error"
                :size="small ? 25 : 50"
            >
                fas fa-exclamation-triangle
            </v-icon>
        </v-col>
        <v-col
            v-if="!small"
            cols="12"
            class="text-center"
        >
            <p>{{ $vuetify.lang.t('$vuetify.text.component.error') }}</p>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "ComponentError",

        props: {
            small: {
                type: Boolean,
                default: false,
            },
        }
    }
</script>
