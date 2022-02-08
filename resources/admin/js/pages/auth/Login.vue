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
                    v-text="$vuetify.lang.t('$vuetify.word.welcome')"
                />
            </v-card-title>
            <v-card-text class="pb-0">
                <v-text-field
                    v-model="data.email"
                    class="pb-2"
                    :error="error"
                    :error-messages="errors.email"
                    :label="$vuetify.lang.t('$vuetify.word.email')"
                    dense
                    outlined
                    required
                    autofocus
                    type="email"
                    hide-details
                />
                <v-text-field
                    v-model="data.password"
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
                <v-checkbox
                    v-model="data.remember"
                    class="ma-0"
                    :label="$vuetify.lang.t('$vuetify.word.remember_me')"
                    dense
                    hide-details
                />
            </v-card-text>
            <v-card-actions class="px-4">
                <v-row no-gutters>
                    <v-btn
                        class="mb-2 mt-1"
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
    import {mapGetters} from "vuex";
    import LAuth from '../../layout/base/Auth'
    import SvgLogoLine from '../../components/svg/LogoLine'

    export default {
        name: "Login",

        components: {
            LAuth,
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

        data() {
            return {
                show: false,
                data: {
                    email: '',
                    password: '',
                    remember: false,
                }
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

            this.$root.responseActions(this.responseData)
        },

        methods: {
            send() {
                this.$store.dispatch('guest/login', this.data)
            },

            enter(e) {
                if (e.key === 'Enter') {
                    this.send()
                }
            }
        },
    }
</script>
