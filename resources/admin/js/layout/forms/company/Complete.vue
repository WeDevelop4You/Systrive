<template>
    <v-row no-gutters>
        <v-col cols="12">
            <v-text-field
                v-model="value.email"
                :error-messages="errors.email"
                :class="{'mb-2': !errors.email}"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.domain"
                :class="{'mb-2': !errors.domain}"
                :error-messages="errors.domain"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-textarea
                v-model="value.information"
                :label="$vuetify.lang.t('$vuetify.word.information')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "Complete",

        props: {
            value: {
                required: true,
                type: Object,
            },

            errors: {
                required: true,
                type: Object
            }
        },
    }
</script>
