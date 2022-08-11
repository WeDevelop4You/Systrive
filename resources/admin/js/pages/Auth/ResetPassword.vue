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
                <password-requirements :errors="errors" />
            </v-card-subtitle>
            <v-card-text class="pb-0">
                <f-password vuex-namespace="user/guest/resetPasswordFrom" />
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
    import LAuth from "../../layout/Base/Auth.vue";
    import FPassword from '../../layout/Forms/PasswordForm.vue'
    import SvgLogoLine from '../../svg/LogoLine.vue'
    import PasswordRequirements from "../../components/PasswordRequirements.vue";

    export default {
        name: "PasswordReset",

        components: {
            LAuth,
            FPassword,
            SvgLogoLine,
            PasswordRequirements
        },

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

        computed: {
            errors() {
                return this.$store.getters["user/guest/resetPasswordForm/errors"]
            },
        },

        created() {
            window.addEventListener('keydown', this.enter)

            this.$store.commit('user/guest/resetPasswordForm/setData', {
                token: this.token,
                user_token: this.encryptEmail
            })
        },

        methods: {
            send() {
                this.$store.dispatch('user/guest/resetPassword')
            },

            enter(e) {
                if (e.key === 'Enter') {
                    this.send()
                }
            }
        },
    }
</script>
