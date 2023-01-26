<template>
    <v-text-field
        v-show="isHidden"
        v-bind="component.attributes"
        :value="input"
        :disabled="isDisabled"
        :label="component.content.label"
        :error-messages="errorMessages"
        :error="component.data.error && error"
        :type="show ? 'text' : 'password'"
        :append-icon="show ? 'fas fa-eye' : 'fas fa-eye-slash'"
        :hide-details="hideDetails"
        :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
        @click:append="show = !show"
        @input="setValue($event)"
    />
</template>

<script>
    import FormComponentBase from "../../Base/FormComponentBase";

    export default {
        name: "PasswordInput",

        extends: FormComponentBase,

        data() {
            return {
                show: false,
            }
        },
    }
</script>
