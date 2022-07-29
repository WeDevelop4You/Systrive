<template>
    <v-text-field
        v-model="data[key]"
        v-bind="value.attributes"
        :disabled="isDisabled"
        :label="value.content.label"
        :error-messages="errors[key]"
        @input="clearError(key)"
    />
</template>

<script>
    import FormProperties from "../../../mixins/Form/FormProperties";

    export default {
        name: "TextInput",

        mixins: [
            FormProperties
        ]
    }
</script>
