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
                <v-row
                    no-gutters
                    class="gap-3 justify-end mx-2"
                >
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
                </v-row>
            </v-card-actions>
        </v-card>
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Base/Auth.vue'
    import FLogin from '../../layout/Forms/LoginForm.vue'
    import SvgLogoLine from '../../svg/Logo.vue'

    export default {
        name: "Login",

        components: {
            LAuth,
            FLogin,
            SvgLogoLine,
        },

        props: {
            link: {
                required: true,
                type: String,
            },

            response: {
                required: true,
                type: Array,
            },
        },

        created() {
            this.response.forEach((data) => {
                this.$responseChain(data)
            })
        },

        methods: {
            send() {
                this.$store.dispatch('user/guest/login').catch(() => {})
            }
        },
    }
</script>
