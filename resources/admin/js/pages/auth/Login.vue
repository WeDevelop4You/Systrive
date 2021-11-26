<template>
    <l-auth>
        <v-card-title>
            <svg-logo-line class="ma-6" />
            <div class="mx-auto font-weight-bold">
                {{ $vuetify.lang.t('$vuetify.word.welcome') }}
            </div>
        </v-card-title>
        <v-card-text class="pb-0">
            <v-text-field
                v-model="email"
                class="pb-2"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                outlined
                dense
                type="text"
                :error="error"
                :error-messages="errorMessages.email"
                hide-details
                autofocus
                required
            />
            <v-text-field
                v-model="password"
                :label="$vuetify.lang.t('$vuetify.word.password')"
                outlined
                dense
                :type="show ? 'text' : 'password'"
                :error-messages="errorMessages.password"
                :append-icon="show ? 'faSvg fa-eye' : 'fas fa-eye-slash'"
                required
                @click:append="show = !show"
            />
            <v-checkbox
                v-model="remember"
                class="ma-0"
                :label="$vuetify.lang.t('$vuetify.word.remember_me')"
                dense
                hide-details
            />
        </v-card-text>
        <v-card-actions class="px-4">
            <v-row no-gutters>
                <v-btn
                    class="mb-2"
                    color="primary"
                    block
                    :disabled="$loading"
                    @click="send"
                >
                    {{ $vuetify.lang.t('$vuetify.word.login.login') }}
                </v-btn>
                <v-btn
                    x-small
                    text
                    block
                    :href="link"
                >
                    {{ $vuetify.lang.t('$vuetify.word.forgot_password') }}
                </v-btn>
            </v-row>
        </v-card-actions>
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Auth'
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
            }
        },

        data() {
            return {
                email: '',
                show: false,
                password: '',
                error: false,
                remember: false,
                errorMessages: {},
            }
        },

        created() {
            window.addEventListener('keydown', this.enter)

            this.$root.responseActions(this.responseData)
        },

        beforeDestroy() {
            window.removeEventListener('keydown', this.enter);
        },

        methods: {
            send() {
                let app = this

                this.$api.getCsrfToken().then(() => {
                    app.$api.call({
                        url: '/login',
                        method: "POST",
                        data: {
                            email: app.email,
                            password: app.password,
                            remember: app.remember
                        },
                    }).then((response) => {
                        window.location.href = response.data.redirect
                    }).catch((error) => {
                        const errors = error.response.data.errors

                        if (Object.prototype.hasOwnProperty.call(errors,'failed')) {
                            app.error = true
                            app.errorMessages = {'password': errors.failed}
                        } else {
                            app.errorMessages = errors
                        }
                    })
                })
            },

            enter(e) {
                if (e.key === 'Enter') {
                    this.send()
                }
            }
        },
    }
</script>
