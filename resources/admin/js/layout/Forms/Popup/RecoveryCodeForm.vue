<template>
    <v-text-field
        v-model="data.recovery_code"
        :error-messages="errors.recovery_code"
        :label="$vuetify.lang.t('$vuetify.word.recovery_code')"
        hide-details="auto"
        outlined
        dense
        @input="clearError('recovery_code')"
    />
</template>

<script>
    import CustomFormProperties from "../../../mixins/Form/CustomFormProperties";

    export default {
        name: "RecoveryCode",

        mixins: [
            CustomFormProperties
        ],
    }
</script>
