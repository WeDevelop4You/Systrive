<template>
    <v-row dense>
        <v-col cols="12">
            <v-text-field
                v-model="data.email"
                :error="error"
                :error-messages="errors.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                dense
                outlined
                autofocus
                type="email"
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="data.password"
                :error-messages="errors.password"
                :type="show ? 'text' : 'password'"
                :append-icon="show ? 'faSvg fa-eye' : 'fas fa-eye-slash'"
                :label="$vuetify.lang.t('$vuetify.word.password.password')"
                dense
                outlined
                hide-details="auto"
                @click:append="show = !show"
            />
        </v-col>
        <v-col cols="12">
            <v-checkbox
                v-model="data.remember"
                class="ma-0"
                :label="$vuetify.lang.t('$vuetify.word.remember_me')"
                dense
                hide-details
            />
        </v-col>
    </v-row>
</template>

<script>
    import customFormProperties from "../../mixins/CustomFormProperties";

    export default {
        name: "Login",

        mixins: [
            customFormProperties
        ],

        data() {
            return {
                show: false,
            }
        },
    }
</script>
