<template>
    <v-row dense>
        <v-otp-input
            v-model="data.one_time_password"
            class="mx-auto"
            style="width: 275px"
            @finish="$emit('defaultAction')"
        />
        <error-message
            class="mx-1"
            :message="errors.one_time_password"
        />
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
        ],

        created() {
            this.data.one_time_password = ''
        }
    }
</script>
