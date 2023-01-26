<template>
    <v-textarea
        v-show="isHidden"
        v-bind="component.attributes"
        :ref="key"
        :value="input"
        :disabled="isDisabled"
        :label="component.content.label"
        :error-messages="errorMessages"
        :hide-details="hideDetails"
        :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
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
