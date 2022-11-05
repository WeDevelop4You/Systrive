<template>
    <v-textarea
        v-bind="component.attributes"
        :ref="key"
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
        name: "TextareaInput",

        extends: FormComponentBase,

    }
</script>
