<template>
    <l-auth>
        <v-card
            class="mx-auto"
            rounded="lg"
            outlined
            :elevation="$config.elevation"
            width="400px"
            @keyup.enter="send"
        >
            <v-card-title>
                <svg-logo-line class="ma-6" />
                <div
                    class="mx-auto text-h6 font-weight-bold"
                    v-text="$vuetify.lang.t('$vuetify.word.welcome')"
                />
            </v-card-title>
            <v-card-text class="pb-0">
                <f-login vuex-namespace="user/guest/loginForm" />
            </v-card-text>
            <v-card-actions>
                <l-buttons no-padding>
                    <v-btn
                        :disabled="$loading"
                        block
                        color="primary"
                        @click="send"
                    >
                        {{ $vuetify.lang.t('$vuetify.word.login.login') }}
                    </v-btn>
                    <v-btn
                        :href="link"
                        text
                        block
                        x-small
                    >
                        {{ $vuetify.lang.t('$vuetify.word.forgot_password') }}
                    </v-btn>
                </l-buttons>
            </v-card-actions>
        </v-card>
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Base/Auth'
    import FLogin from '../../layout/Forms/LoginForm'
    import SvgLogoLine from '../../svg/LogoLine'
    import LButtons from "../../layout/ButtonLayout";

    export default {
        name: "Login",

        components: {
            LAuth,
            FLogin,
            LButtons,
            SvgLogoLine,
        },

        props: {
            link: {
                required: true,
                type: String,
            },

            responseData: {
                required: true,
                type: Object,
            },
        },

        created() {
            this.$responseChain(this.responseData)
        },

        methods: {
            send() {
                this.$store.dispatch('user/guest/login').catch(() => {})
            }
        },
    }
</script>
