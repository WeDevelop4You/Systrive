<template>
    <v-checkbox
        v-show="isHidden"
        v-bind="component.attributes"
        :disabled="isDisabled"
        :input-value="getValue"
        :error-messages="errorMessages"
        :label="component.content.label"
        :hide-details="hideDetails"
        :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
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

