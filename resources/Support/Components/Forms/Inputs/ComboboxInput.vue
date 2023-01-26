<template>
    <v-combobox
        v-show="isHidden"
        v-bind="component.attributes"
        :ref="key"
        :value="input"
        :disabled="isDisabled"
        :items="component.data.items"
        :label="component.content.label"
        :error-messages="errorMessages"
        :hide-details="hideDetails"
        :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
        @change="setValue($event)"
        @click:clear="setValue(null)"
    />
</template>
x
<script>
    import DropdownFormComponentBase from "../../Base/DropdownFormComponentBase";

    export default {
        name: "SelectInput",

        extends: DropdownFormComponentBase
    }
</script>
