<template>
    <l-auth>
        <v-card
            class="mx-auto"
            rounded="lg"
            outlined
            :elevation="$config.elevation"
            width="400px"
        >
            <v-card-title>
                <svg-logo-line class="ma-6" />
                <div
                    class="mx-auto text-h6 font-weight-bold"
                    v-text="$vuetify.lang.t('$vuetify.word.reset.password')"
                />
            </v-card-title>
            <v-card-subtitle class="pa-4">
                <password-requirements :errors="errors"/>
            </v-card-subtitle>
            <v-card-text class="pb-0">
                <f-password
                    v-model="data"
                    :error="error"
                    :errors="errors"
                />
            </v-card-text>
            <v-card-actions>
                <v-btn
                    block
                    color="primary"
                    :disabled="$loading"
                    @click="send"
                >
                    {{ $vuetify.lang.t('$vuetify.word.reset.password') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </l-auth>
</template>

<script>
    import {mapGetters} from "vuex";
    import LAuth from "../../layout/Auth";
    import FPassword from '../../layout/forms/Password'
    import SvgLogoLine from '../../components/svg/LogoLine'
    import PasswordRequirements from "../../components/PasswordRequirements";

    export default {
        name: "PasswordReset",

        props: {
            token: {
                required: true,
                type: String,
            },

            encryptEmail: {
                required: true,
                type: String,
            }
        },

        components: {
            LAuth,
            FPassword,
            SvgLogoLine,
            PasswordRequirements
        },

        data() {
            return {
                data: {
                    token: this.token,
                    user_token: this.encryptEmail,
                    password: '',
                    password_confirm: '',
                },
            }
        },

        computed: {
            ...mapGetters({
                error: 'guest/error',
                errors: 'guest/errors'
            })
        },

        created() {
            window.addEventListener('keydown', this.enter)
        },

        methods: {
            send() {
                this.$store.dispatch('guest/resetPassword', this.data)
            },

            enter(e) {
                if (e.key === 'Enter') {
                    this.send()
                }
            }
        },
    }
</script>
