<template>
    <v-row dense>
        <v-otp-input
            v-model="data.one_time_password"
            style="width: 275px"
            class="mx-auto"
            @finish="$emit('defaultAction')"
        />
        <error-message :message="errors.one_time_password" />
    </v-row>
</template>

<script>
    import ErrorMessage from "../../../components/Items/ErrorMessage";
    import customFormProperties from "../../../mixins/Form/CustomFormProperties";

    export default {
        name: "OneTimePassword",

        components: {
            ErrorMessage
        },

        mixins: [
            customFormProperties
        ]
    }
</script>
