<template>
    <v-text-field
        v-bind="component.attributes"
        :value="input"
        :disabled="isDisabled"
        :label="component.content.label"
        :error-messages="errorMessages"
        :error="component.data.error && error"
        :hide-details="hideDetails"
        :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
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
