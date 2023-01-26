<template>
    <div>
        <v-otp-input
            v-bind="component.attributes"
            :value="input"
            @input="setValue"
            @finish="$actions.call(component.data.action)"
        />
        <error-message
            class="mx-1"
            :message="errorMessages"
        />
    </div>
</template>

<script>
    import ErrorMessage from "../../Misc/ErrorMessage.vue";
    import FormComponentBase from "../../Base/FormComponentBase";

    export default {
        name: "OneTimePasswordInput",

        components: {
            ErrorMessage
        },

        extends: FormComponentBase,
    }
</script>
