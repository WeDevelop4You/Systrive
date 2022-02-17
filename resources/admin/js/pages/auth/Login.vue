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
                <f-login
                    v-model="data"
                    :errors="errors"
                    :error="error"
                />
            </v-card-text>
            <v-card-actions class="px-4">
                <v-row no-gutters>
                    <v-btn
                        class="mb-2 mt-1"
                        :disabled="$loading"
                        block
                        color="primary"
                        small
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
    import {mapGetters} from "vuex";
    import LAuth from '../../layout/base/Auth'
    import FLogin from '../../layout/forms/Login'
    import SvgLogoLine from '../../components/svg/LogoLine'

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

            responseData: {
                required: true,
                type: Object,
            },
        },

        computed: {
            data: {
                get() {
                    return this.$store.getters["guest/credentials"]
                },

                set(values) {
                    this.$store.commit('guest/setCredentials', values)
                }
            },

            ...mapGetters({
                error: 'guest/error',
                errors: 'guest/errors'
            })
        },

        created() {
            this.$root.responseMethodChain(this.responseData)
        },

        methods: {
            send() {
                this.$store.dispatch('guest/login').catch(() => {})
            }
        },
    }
</script>
