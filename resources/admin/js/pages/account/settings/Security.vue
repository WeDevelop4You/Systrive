<template>
    <div class="grid gap-3">
        <v-card :elevation="$config.elevation">
            <v-card-title v-text="$vuetify.lang.t('$vuetify.word.change.password')" />
            <v-card-subtitle>
                <password-requirements :errors="errors" />
            </v-card-subtitle>
            <v-card-text class="pb-0">
                <f-password
                    v-model="data"
                    :errors="errors"
                    :error="passwordError"
                    :is-editing="true"
                />
            </v-card-text>
            <v-card-actions>
                <v-btn
                    class="ml-auto"
                    color="primary"
                    :disabled="$loading"
                    @click="change"
                >
                    {{ $vuetify.lang.t('$vuetify.word.change.password') }}
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-card :elevation="$config.elevation">
            <v-card-title v-text="$vuetify.lang.t('$vuetify.word.2fa')" />
            <v-card-text>
                <v-row>
                    <v-col />
                    <v-col />
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import FPassword from "../../../layout/forms/Password";
    import PasswordRequirements from "../../../components/PasswordRequirements";
    import Password from "../../../mixins/Password";


    export default {
        name: "Security",

        components: {
            FPassword,
            PasswordRequirements
        },

        mixins: [
            Password
        ],

        data() {
            return {
                data: {
                    current_password: '',
                    password: '',
                    password_confirm: '',
                },
                defaultData: {}
            }
        },

        computed: {
            errors() {
                return this.passwordErrors(this.$store.getters['user/security/errors'])
            },
        },

        create() {
            Object.assign(this.defaultData, this.data)
        },

        methods: {
            change() {
                let app = this;

                this.passwordError = false
                this.$store.dispatch('user/security/changePassword', this.data).then((response) => {
                    if (response) {
                        app.data = Object.assign({}, app.defaultData)
                    }
                })
            },
        }
    }
</script>
