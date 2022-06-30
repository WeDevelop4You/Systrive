<template>
    <v-row dense>
        <v-col cols="12">
            <v-text-field
                v-model="data.email"
                :error-messages="errors.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                dense
                outlined
                type="email"
                hide-details="auto"
            />
        </v-col>
    </v-row>
</template>

<script>
import CustomFormProperties from "../../mixins/Form/CustomFormProperties";

export default {
    name: "RecoveryForm",

    mixins: [
        CustomFormProperties
    ]
}
</script>
