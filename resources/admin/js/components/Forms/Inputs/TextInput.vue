<template>
    <v-text-field
        v-bind="component.attributes"
        :value="getValue"
        :disabled="isDisabled"
        :label="component.content.label"
        :error-messages="errorMessages"
        @input="setValue($event)"
    />
</template>

<script>
    import FormComponentBase from "../../Base/FormComponentBase";

    export default {
        name: "TextInput",

        extends: FormComponentBase,

    }
</script>
