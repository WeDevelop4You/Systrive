<template>
    <l-auth>
        <v-card-title>
            <svg-logo-line class="ma-6"/>
            <div class="mx-auto font-weight-bold">{{ $vuetify.lang.t('$vuetify.word.welcome') }}</div>
        </v-card-title>
        <v-card-text class="pb-0">
            <v-text-field class="pb-2" v-model="email" :label="$vuetify.lang.t('$vuetify.word.email')" outlined dense type="text" :error="error" :error-messages="errorMessages.email" hide-details autofocus required/>
            <v-text-field v-model="password" :label="$vuetify.lang.t('$vuetify.word.password')" outlined dense :type="show ? 'text' : 'password'" :error-messages="errorMessages.password" :append-icon="show ? 'faSvg fa-eye' : 'fas fa-eye-slash'" @click:append="show = !show" required/>
            <v-checkbox class="ma-0" v-model="remember" :label="$vuetify.lang.t('$vuetify.word.remember_me')" dense hide-details></v-checkbox>
        </v-card-text>
        <v-card-actions class="px-4">
            <v-row no-gutters>
                <v-btn class="mb-2" color="primary" block v-on:click="send" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.login.login') }}</v-btn>
                <v-btn x-small text block :href="link">{{ $vuetify.lang.t('$vuetify.word.forgot_password') }}</v-btn>
            </v-row>
        </v-card-actions>
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Auth'
    import SvgLogoLine from '../../components/svg/LogoLine'

    export default {
        name: "login",

        props: {
            link: {
                required: true,
                type: String,
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

        components: {
            LAuth,
            SvgLogoLine,
        },

        created() {
            window.addEventListener('keydown', this.enter)
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
                        console.log(error.response.data.errors.hasOwnProperty('failed'))

                        if (error.response.data.errors.hasOwnProperty('failed')) {
                            app.error = true
                            app.errorMessages = {'password': error.response.data.errors.failed}
                        } else {
                            app.errorMessages = error.response.data.errors
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

        beforeDestroy() {
            window.removeEventListener('keydown', this.enter);
        },
    }
</script>
