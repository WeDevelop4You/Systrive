<template>
    <v-row no-gutters>
        <v-col cols="12">
            <v-text-field
                v-model="value.email"
                class="pb-2"
                :error="error"
                :error-messages="errors.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                dense
                outlined
                required
                autofocus
                type="email"
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.password"
                :class="{'mb-2': !errors.password}"
                :error-messages="errors.password"
                :type="show ? 'text' : 'password'"
                :label="$vuetify.lang.t('$vuetify.word.password.password')"
                :append-icon="show ? 'faSvg fa-eye' : 'fas fa-eye-slash'"
                dense
                required
                outlined
                hide-details="auto"
                @click:append="show = !show"
            />
        </v-col>
        <v-col cols="12">
            <v-checkbox
                v-model="value.remember"
                class="ma-0"
                :label="$vuetify.lang.t('$vuetify.word.remember_me')"
                dense
                hide-details
            />
        </v-col>
    </v-row>
</template>

<script>
    import formProps from "../../mixins/FormProps";

    export default {
        name: "Login",

        mixins: [
            formProps
        ],

        props: {
            error: {
                required: true,
                type: Boolean
            }
        },

        data() {
            return {
                show: false,
            }
        },
    }
</script>
