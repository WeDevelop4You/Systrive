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
                    class="mx-auto font-weight-bold"
                    v-text="$vuetify.lang.t('$vuetify.word.forgot_password')"
                />
            </v-card-title>
            <v-card-subtitle class="pa-4">
                <div class="text-center text--disabled">
                    {{ $vuetify.lang.t('$vuetify.text.password.forgot') }}
                </div>
            </v-card-subtitle>
            <v-card-text class="pb-0">
                <RecoveryForm vuex-namespace="user/guest/passwordRecoveryForm" />
            </v-card-text>
            <v-card-actions>
                <l-buttons>
                    <v-btn
                        block
                        color="primary"
                        :disabled="$loading"
                        @click="send"
                    >
                        {{ $vuetify.lang.t('$vuetify.word.send_email') }}
                    </v-btn>
                </l-buttons>
            </v-card-actions>
        </v-card>
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Base/Auth'
    import SvgLogoLine from '../../svg/LogoLine'
    import LButtons from "../../layout/ButtonLayout";
    import RecoveryForm from "../../layout/Forms/RecoveryForm";

    export default {
        name: "PasswordRecovery",

        components: {
            LAuth,
            LButtons,
            SvgLogoLine,
            RecoveryForm,
        },

        created() {
            window.addEventListener('keydown', this.enter)
        },

        methods: {
            send() {
                this.$store.dispatch('user/guest/sendEmail')
            },

            enter(e) {
                if (e.key === 'Enter') {
                    this.send()
                }
            }
        },
    }
</script>
