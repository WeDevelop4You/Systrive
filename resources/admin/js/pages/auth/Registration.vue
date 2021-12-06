<template>
    <l-auth>
        <v-stepper
            v-model="step"
            :elevation="$config.elevation"
            rounded="lg"
            outlined
            vertical
        >
            <svg-logo-line class="ma-6" />
            <div
                class="text-center text-h6 font-weight-bold"
                v-text="$vuetify.lang.t('$vuetify.word.registration')"
            />
            <v-stepper-step
                :complete="step > 1"
                :rules="[() => passwordError]"
                step="1"
            >
                {{ $vuetify.lang.t('$vuetify.word.password.password') }}
            </v-stepper-step>
            <v-stepper-content step="1">
                <v-row
                    class="pt-2"
                    no-gutters
                >
                    <v-text-field
                        v-model="email"
                        :label="$vuetify.lang.t('$vuetify.word.email')"
                        dense
                        outlined
                        disabled
                        hide-details
                    />
                    <v-col cols="12" class="py-4">
                        <password-requirements :errors="errors"/>
                    </v-col>
                </v-row>
                <f-password
                    v-model="data"
                    :error="error"
                    :errors="errors"
                />
                <v-row no-gutters class="justify-end gap-3">
                    <v-btn
                        text
                        v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                        @click="GoToLogin"
                    />
                    <v-btn
                        color="primary"
                        v-text="$vuetify.lang.t('$vuetify.word.next')"
                        @click="NextProfile"
                    />
                </v-row>
            </v-stepper-content>
            <v-stepper-step
                :complete="step > 2"
                :rules="[() => profileError]"
                step="2"
            >
                {{ $vuetify.lang.t('$vuetify.word.profile.profile') }}
            </v-stepper-step>
            <v-stepper-content step="2">
                <f-user-profile
                    class="pt-2"
                    v-model="data"
                    :errors="errors"
                />
                <v-row no-gutters class="justify-end gap-3">
                    <v-btn
                        text
                        v-text="$vuetify.lang.t('$vuetify.word.back')"
                        @click="backToPassword"
                    />
                    <v-btn
                        color="primary"
                        v-text="$vuetify.lang.t('$vuetify.word.next')"
                        @click="nextAccept"
                    />
                </v-row>
            </v-stepper-content>
            <v-stepper-step
                :rules="[() => !errors.accept]"
                step="3"
            >
                {{ $vuetify.lang.t('$vuetify.word.accept.accept') }}
            </v-stepper-step>
            <v-stepper-content step="3">
                <v-row no-gutters>
                    <v-col cols="12">
                        <p v-text="$vuetify.lang.t('$vuetify.text.complete.registration')"/>
                    </v-col>
                    <v-col cols="12">
                        <v-checkbox
                            class="ma-0"
                            v-model="data.accept"
                            :error-messages="errors.accept"
                            :label="$vuetify.lang.t('$vuetify.word.terms_and_conditions')"
                            dense
                            hide-details="auto"
                        />
                    </v-col>
                    <v-col cols="12">
                        <v-row no-gutters class="justify-end gap-3">
                            <v-btn
                                text
                                v-text="$vuetify.lang.t('$vuetify.word.back')"
                                @click="backToProfile"
                            />
                            <v-btn
                                color="primary"
                                v-text="$vuetify.lang.t('$vuetify.word.accept.accept')"
                                @click="send"
                            />
                        </v-row>
                    </v-col>
                </v-row>
            </v-stepper-content>
        </v-stepper>
    </l-auth>
</template>

<script>
    import {mapGetters} from "vuex";
    import LAuth from '../../layout/Auth'
    import FPassword from '../../layout/forms/Password'
    import SvgLogoLine from '../../components/svg/LogoLine'
    import FUserProfile from '../../layout/forms/UserProfile'
    import PasswordRequirements from "../../components/PasswordRequirements";

    export default {
        name: "Registration",

        components: {
            LAuth,
            FPassword,
            SvgLogoLine,
            FUserProfile,
            PasswordRequirements,
        },

        props: {
            link: {
                required: true,
                type: String
            },

            email: {
                required: true,
                type: String
            }
        },

        data () {
            return {
                step: 1,
                data: {
                    password: '',
                    password_confirm: '',

                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    gender: '',
                    birth_date: '',

                    accept: false
                },
            }
        },

        computed: {
            passwordError() {
                return !(
                    this.errors.password ||
                    this.errors.password_confirm ||
                    this.errors.characters ||
                    this.errors.mixedCase ||
                    this.errors.number ||
                    this.errors.symbol
                )
            },

            profileError() {
                return !(
                    this.errors.first_name ||
                    this.errors.middle_name ||
                    this.errors.last_name ||
                    this.errors.gender ||
                    this.errors.birth_date
                )
            },

            ...mapGetters({
                error: 'guest/error',
                errors: 'guest/errors',
            })
        },

        methods: {
            GoToLogin() {
                window.location.href = this.link
            },

            backToPassword() {
                this.step = 1
            },

            backToProfile() {
                this.step = 2
            },

            NextProfile() {
                let app = this

                this.$store.dispatch('guest/resetError')

                app.$api.getCsrfToken().then(() => {
                    this.$api.call({
                        url: app.$api.route('registration.validation.password'),
                        method: "POST",
                        data: {
                            password: app.data.password,
                            password_confirm: app.data.password_confirm,
                        },
                    }).then(() => {
                        app.step = 2
                    }).catch((error) => {
                        let errors = error.response.data.errors || {}

                        app.$store.dispatch('guest/passwordError', errors)
                    })
                });
            },

            nextAccept() {
                let app = this

                app.$api.getCsrfToken().then(() => {
                    this.$api.call({
                        url: app.$api.route('registration.validation.profile'),
                        method: "POST",
                        data: {
                            first_name: app.data.first_name,
                            middle_name: app.data.middle_name,
                            last_name: app.data.last_name,
                            gender: app.data.gender,
                            birth_date: app.data.birth_date,
                        }
                    }).then(() => {
                        this.step = 3
                    }).catch((error) => {
                        let errors = error.response.data.errors || {}

                        app.$store.commit('guest/setErrors', errors)
                    })
                })
            },

            send() {
                let app = this

                this.$store.dispatch('guest/resetError')

                app.$api.getCsrfToken().then(() => {
                    this.$api.call({
                        url: app.$api.route('registration'),
                        method: "POST",
                        data: app.data
                    }).catch((error) => {
                        let errors = error.response.data.errors || {}

                        app.$store.dispatch('guest/passwordError', errors)
                    })
                })
            }
        }
    }
</script>
