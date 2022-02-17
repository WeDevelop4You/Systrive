<template>
    <v-row no-gutters>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <v-text-field
                v-model="value.current_password"
                :error-messages="errors.current_password"
                :class="{'pb-2': !errors.current_password}"
                :type="show_1 ? 'text' : 'password'"
                :label="$vuetify.lang.t('$vuetify.word.current.password')"
                :append-icon="show_1 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                dense
                outlined
                hide-details="auto"
                @click:append="show_1 = !show_1"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.password"
                :error="error"
                :error-messages="errors.password"
                :class="{'pb-2': !errors.password}"
                :type="show_2 ? 'text' : 'password'"
                :label="$vuetify.lang.t('$vuetify.word.password.password')"
                :append-icon="show_2 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                dense
                outlined
                hide-details="auto"
                @click:append="show_2 = !show_2"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.password_confirm"
                :error="error"
                :type="show_3 ? 'text' : 'password'"
                :error-messages="errors.password_confirm"
                :class="{'pb-2': !errors.password_confirm}"
                :append-icon="show_3 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                :label="$vuetify.lang.t('$vuetify.word.confirm.password')"
                dense
                outlined
                hide-details="auto"
                @click:append="show_3 = !show_3"
            />
        </v-col>
    </v-row>
</template>

<script>
    import FromProps from "../../mixins/FormProps";

    export default {
        name: "Password",

        mixins: [
            FromProps
        ],

        props: {
            error: {
                required: true,
                type: Boolean,
            }
        },

        data() {
            return {
                show_1: false,
                show_2: false,
                show_3: false,
            }
        }
    }
</script>
