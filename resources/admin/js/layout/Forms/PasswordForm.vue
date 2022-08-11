<template>
    <v-row dense>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <v-text-field
                v-model="data.current_password"
                :error-messages="errors.current_password"
                :type="show_1 ? 'text' : 'password'"
                :label="$vuetify.lang.t('$vuetify.word.current.password')"
                :append-icon="show_1 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                dense
                outlined
                hide-details="auto"
                @click:append="show_1 = !show_1"
                @input="clearError('current_password')"
            />
        </v-col>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <password-requirements :errors="errors" />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="data.password"
                :error="error"
                :error-messages="errors.password"
                :type="show_2 ? 'text' : 'password'"
                :label="$vuetify.lang.t('$vuetify.word.password.password')"
                :append-icon="show_2 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                dense
                outlined
                hide-details="auto"
                @click:append="show_2 = !show_2"
                @input="clearError('password')"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="data.password_confirm"
                :error="error"
                :type="show_3 ? 'text' : 'password'"
                :error-messages="errors.password_confirm"
                :append-icon="show_3 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                :label="$vuetify.lang.t('$vuetify.word.confirm.password')"
                dense
                outlined
                hide-details="auto"
                @click:append="show_3 = !show_3"
                @input="clearError('password_confirm')"
            />
        </v-col>
    </v-row>
</template>

<script>
    import CustomFormProperties from "../../mixins/Form/CustomFormProperties";
    import PasswordRequirements from "../../components/PasswordRequirements.vue";

    export default {
        name: "Password",

        components: {
            PasswordRequirements
        },

        mixins: [
            CustomFormProperties
        ],

        data() {
            return {
                show_1: false,
                show_2: false,
                show_3: false,
            }
        }
    }
</script>
