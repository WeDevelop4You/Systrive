<template>
    <v-row dense>
        <v-col cols="12">
            <v-text-field
                v-model="data.email"
                :error-messages="errors.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('email')"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="data.domain"
                :error-messages="errors.domain"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('domain')"
            />
        </v-col>
        <v-col cols="12">
            <v-textarea
                v-model="data.information"
                :label="$vuetify.lang.t('$vuetify.word.information')"
                dense
                outlined
                hide-details
            />
        </v-col>
    </v-row>
</template>

<script>
    import CustomFormProperties from "../../../mixins/Form/CustomFormProperties";

    export default {
        name: "CompanyCompleteForm",

        mixins: [
            CustomFormProperties
        ],
    }
</script>
