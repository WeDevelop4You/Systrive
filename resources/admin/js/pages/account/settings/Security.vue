<template>
    <div class="grid gap-3">
        <v-card
            :elevation="$config.elevation"
            outlined
            rounded="lg"
        >
            <v-card-title v-text="$vuetify.lang.t('$vuetify.word.password.password')" />
            <v-card-text>
                <v-row no-gutters>
                    <p
                        class="mb-0 align-self-center"
                        v-text="$vuetify.lang.t('$vuetify.text.change.password')"
                    />
                    <v-spacer />
                    <setting-modal
                        v-model="passwordValues.dialog"
                        :form-title="$vuetify.lang.t('$vuetify.word.change.password')"
                        :button-title="$vuetify.lang.t('$vuetify.word.change.password')"
                        width="400px"
                        @save="password"
                        @close="$store.commit('user/security/clearPasswordValues')"
                    >
                        <template #subtitle>
                            <v-card-subtitle class="pt-3">
                                <password-requirements :errors="errors" />
                            </v-card-subtitle>
                        </template>
                        <f-password
                            v-model="passwordValues"
                            :errors="errors"
                            :error="passwordError"
                            :is-editing="true"
                        />
                    </setting-modal>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card
            :elevation="$config.elevation"
            outlined
            rounded="lg"
        >
            <v-card-title v-text="$vuetify.lang.t('$vuetify.word.2fa')" />
            <v-card-text>
                <v-row no-gutters>
                    <template v-if="$auth.user().isSecured">
                        <p
                            class="mb-0 align-self-center"
                            v-text="$vuetify.lang.t('$vuetify.text.disable.2fa')"
                        />
                        <v-spacer />
                        <v-btn
                            small
                            outlined
                            color="error"
                            @click="$store.dispatch('user/security/disable2FA')"
                        >
                            {{ $vuetify.lang.t('$vuetify.word.disable.disable') }}
                        </v-btn>
                    </template>
                    <template v-else>
                        <p
                            class="mb-0 align-self-center"
                            v-text="$vuetify.lang.t('$vuetify.text.enable.2fa')"
                        />
                        <v-spacer />
                        <setting-modal
                            v-model="twoFAValues.dialog"
                            :form-title="$vuetify.lang.t('$vuetify.word.setup.2fa')"
                            :button-title="$vuetify.lang.t('$vuetify.word.enable.enable')"
                            no-padding
                            no-action
                            @open="$store.dispatch('user/security/getQRCode')"
                            @close="$store.commit('user/security/cleaTwoFAValues')"
                        >
                            <v-stepper
                                v-model="twoFAValues.step"
                                vertical
                                tile
                                flat
                            >
                                <v-stepper-step
                                    :complete="twoFAValues.step > 1"
                                    step="1"
                                >
                                    {{ $vuetify.lang.t('$vuetify.word.scan.qr.code') }}
                                </v-stepper-step>
                                <v-stepper-content step="1">
                                    <p
                                        v-text="$vuetify.lang.t('$vuetify.text.how.to.enable.2fa')"
                                    />
                                    <loading-image
                                        :src="twoFAValues.QRCode"
                                        alt="2fa-qr-code"
                                        max-width="200"
                                        max-height="200"
                                        min-height="200"
                                        class="mx-auto mb-3"
                                    />
                                    <l-buttons no-padding>
                                        <v-btn
                                            text
                                            small
                                            @click="$store.commit('user/security/changeTwoFADialog', false)"
                                            v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                                        />
                                        <v-btn
                                            small
                                            color="primary"
                                            :disabled="$loading"
                                            @click="twoFAValues.step = 2"
                                            v-text="$vuetify.lang.t('$vuetify.word.next')"
                                        />
                                    </l-buttons>
                                </v-stepper-content>
                                <v-stepper-step
                                    :complete="twoFAValues.step > 2"
                                    step="2"
                                >
                                    {{ $vuetify.lang.t('$vuetify.word.check.2fa') }}
                                </v-stepper-step>
                                <v-stepper-content step="2">
                                    <v-row no-gutters>
                                        <v-col cols="12">
                                            <p
                                                class="mt-3"
                                                v-text="$vuetify.lang.t('$vuetify.text.check.2fa')"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-otp-input
                                                v-model="twoFAValues.oneTimePassword"
                                                style="max-width: 275px"
                                                @finish="validateTwoFA"
                                            />
                                            <error-message :message="errors.one_time_password" />
                                        </v-col>
                                    </v-row>
                                    <l-buttons no-padding>
                                        <v-btn
                                            text
                                            small
                                            @click="twoFAValues.step = 1"
                                            v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                                        />
                                        <v-btn
                                            color="primary"
                                            small
                                            :disabled="$loading"
                                            @click="validateTwoFA"
                                            v-text="$vuetify.lang.t('$vuetify.word.check.check')"
                                        />
                                    </l-buttons>
                                </v-stepper-content>
                            </v-stepper>
                        </setting-modal>
                    </template>
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import Password from "../../../mixins/Password";
    import FPassword from "../../../layout/forms/Password";
    import SettingModal from "../../../components/SettingModal";
    import LoadingImage from "../../../components/LoadingImage";
    import ErrorMessage from "../../../components/ErrorMessage";
    import PasswordRequirements from "../../../components/PasswordRequirements";
    import LButtons from "../../../layout/Buttons";

    export default {
        name: "Security",

        components: {
            LButtons,
            FPassword,
            LoadingImage,
            SettingModal,
            ErrorMessage,
            PasswordRequirements
        },

        mixins: [
            Password
        ],

        computed: {
            passwordValues: {
                get () {
                    return this.$store.getters["user/security/passwordValues"]
                },

                set (values) {
                    this.$store.commit('user/security/setPasswordValues', values)
                }
            },

            twoFAValues: {
                get () {
                    return this.$store.getters["user/security/twoFAValues"]
                },

                set (values) {
                    this.$store.commit("user/security/setTwoFAValues", values)
                }
            },

            errors() {
                return this.passwordErrors(this.$store.getters['user/security/errors'])
            },
        },

        methods: {
            password() {
                this.passwordError = false
                this.$store.dispatch('user/security/changePassword')
            },

            validateTwoFA() {
                this.$store.dispatch('user/security/validateTwoFA')
            }
        }
    }
</script>
