<template>
    <v-checkbox
        v-bind="component.attributes"
        :input-value="getValue"
        :disabled="isDisabled"
        :label="component.content.label"
        :error-messages="errorMessages"
        @change="setValue($event)"
    />
</template>

<script>
    import FormComponentBase from "../../Base/FormComponentBase";

    export default {
        name: "CheckboxInput",

        extends: FormComponentBase
    }
</script>

