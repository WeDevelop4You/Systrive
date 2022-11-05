<template>
    <l-auth>
        <v-stepper
            v-model="step"
            :elevation="$config.elevation"
            rounded="lg"
            outlined
            vertical
            max-width="500px"
        >
            <svg-logo-line class="ma-6" />
            <div
                class="text-center text-h6 font-weight-bold"
                v-text="$vuetify.lang.t('$vuetify.word.registration')"
            />
            <v-stepper-step
                :complete="step > 1"
                :rules="[() => stepPasswordErrors]"
                step="1"
            >
                {{ $vuetify.lang.t('$vuetify.word.password.password') }}
            </v-stepper-step>
            <v-stepper-content step="1">
                <v-row
                    class="pt-2"
                    dense
                >
                    <v-col cols="12">
                        <v-text-field
                            v-model="email"
                            :label="$vuetify.lang.t('$vuetify.word.email')"
                            dense
                            outlined
                            disabled
                            hide-details
                        />
                    </v-col>
                    <v-col
                        cols="12"
                        class="py-4"
                    >
                        <password-requirements :errors="errors" />
                    </v-col>
                </v-row>
                <f-password vuex-namespace="user/registration/form" />
                <v-row dense>
                    <v-col cols="12">
                        <v-row
                            no-gutters
                            class="gap-3 justify-end"
                        >
                            <v-btn
                                text
                                @click="goToLogin"
                                v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                            />
                            <v-btn
                                color="primary"
                                @click="nextProfile"
                                v-text="$vuetify.lang.t('$vuetify.word.next')"
                            />
                        </v-row>
                    </v-col>
                </v-row>
            </v-stepper-content>
            <v-stepper-step
                :complete="step > 2"
                :rules="[() => stepProfileErrors]"
                step="2"
            >
                {{ $vuetify.lang.t('$vuetify.word.profile.profile') }}
            </v-stepper-step>
            <v-stepper-content step="2">
                <user-profile-form
                    vuex-namespace="user/registration/form"
                    registration
                    class="pt-2"
                />
                <v-row
                    class="pt-2"
                    dense
                >
                    <v-col cols="12">
                        <v-row
                            no-gutters
                            class="gap-3 justify-end"
                        >
                            <v-btn
                                text
                                @click="step = 1"
                                v-text="$vuetify.lang.t('$vuetify.word.back')"
                            />
                            <v-btn
                                color="primary"
                                @click="nextAccept"
                                v-text="$vuetify.lang.t('$vuetify.word.next')"
                            />
                        </v-row>
                    </v-col>
                </v-row>
            </v-stepper-content>
            <v-stepper-step
                :rules="[() => !errors.accept]"
                step="3"
            >
                {{ $vuetify.lang.t('$vuetify.word.accept.accept') }}
            </v-stepper-step>
            <v-stepper-content step="3">
                <v-row
                    class="pt-2"
                    dense
                >
                    <v-col cols="12">
                        <p v-text="$vuetify.lang.t('$vuetify.text.complete.registration')" />
                    </v-col>
                    <v-col cols="12">
                        <v-checkbox
                            v-model="data.accept"
                            class="ma-0 pl-2"
                            :error-messages="errors.accept"
                            :label="$vuetify.lang.t('$vuetify.word.terms_and_conditions')"
                            dense
                            hide-details="auto"
                            @change="clearError('accept')"
                        />
                    </v-col>
                    <v-col cols="12">
                        <v-row
                            no-gutters
                            class="gap-3 justify-end"
                        >
                            <v-btn
                                text
                                @click="step = 2"
                                v-text="$vuetify.lang.t('$vuetify.word.back')"
                            />
                            <v-btn
                                color="primary"
                                @click="send"
                                v-text="$vuetify.lang.t('$vuetify.word.accept.accept')"
                            />
                        </v-row>
                    </v-col>
                </v-row>
            </v-stepper-content>
        </v-stepper>
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Base/Auth.vue'
    import FPassword from '../../layout/Forms/PasswordForm.vue'
    import SvgLogoLine from '../../svg/Logo.vue'
    import UserProfileForm from '../../layout/Forms/UserProfileForm.vue'
    import PasswordRequirements from "../../components/PasswordRequirements.vue";
    import FormMethods from "../../mixins/FormMethods";

    export default {
        name: "Registration",

        components: {
            LAuth,
            FPassword,
            SvgLogoLine,
            UserProfileForm,
            PasswordRequirements,
        },

        mixins: [
            FormMethods
        ],

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

        data() {
            return {
                vuexNamespace: 'user/registration'
            }
        },

        computed: {
            step: {
                get() {
                    return this.$store.getters[`${this.vuexNamespace}/step`]
                },

                set(value) {
                    this.$store.commit(`${this.vuexNamespace}/setStep`, value)
                }
            },

            data: {
                get() {
                    return this.$store.getters[`${this.vuexNamespace}/form/data`]
                },

                set(values) {
                    this.$store.commit(`${this.vuexNamespace}/form/setData`, values)
                }
            },

            stepPasswordErrors() {
                return !(
                    this.errors.password ||
                    this.errors.password_confirm ||
                    this.errors.characters ||
                    this.errors.mixedCase ||
                    this.errors.number ||
                    this.errors.symbol
                )
            },

            stepProfileErrors() {
                return !(
                    this.errors.first_name ||
                    this.errors.middle_name ||
                    this.errors.last_name ||
                    this.errors.gender ||
                    this.errors.birth_date
                )
            },

            errors() {
                return this.$store.getters[`${this.vuexNamespace}/form/errors`]
            },
        },

        methods: {
            goToLogin() {
                window.location.href = this.link
            },

            nextProfile() {
                this.$store.dispatch(`${this.vuexNamespace}/nextProfile`)
            },

            nextAccept() {
                this.$store.dispatch(`${this.vuexNamespace}/nextAccept`)
            },

            send() {
                this.$store.dispatch(`${this.vuexNamespace}/send`)
            }
        }
    }
</script>
