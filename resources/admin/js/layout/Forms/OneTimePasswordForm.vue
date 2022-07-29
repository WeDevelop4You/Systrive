<template>
    <v-stepper
        v-model="step"
        vertical
        tile
        flat
    >
        <v-stepper-step
            :complete="step > 1"
            step="1"
        >
            {{ $vuetify.lang.t('$vuetify.word.scan.qr.code') }}
        </v-stepper-step>
        <v-stepper-content step="1">
            <p
                v-text="$vuetify.lang.t('$vuetify.text.how.to.enable.2fa')"
            />
            <loading-image
                :src="data.QRCode"
                alt="2fa-qr-code"
                max-width="200"
                max-height="200"
                min-height="200"
                class="mx-auto mb-3"
            />
            <l-buttons no-padding>
                <v-btn
                    text
                    @click="close"
                    v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                />
                <v-btn
                    color="primary"
                    :disabled="$loading"
                    @click="step = 2"
                    v-text="$vuetify.lang.t('$vuetify.word.next')"
                />
            </l-buttons>
        </v-stepper-content>
        <v-stepper-step
            :complete="step > 2"
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
                        v-model="data.oneTimePassword"
                        style="max-width: 275px"
                        class="mx-auto"
                        @finish="validate"
                    />
                    <error-message :message="errors.one_time_password" />
                </v-col>
            </v-row>
            <l-buttons no-padding>
                <v-btn
                    text
                    @click="step = 1"
                    v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                />
                <v-btn
                    color="primary"
                    :disabled="$loading"
                    @click="validate"
                    v-text="$vuetify.lang.t('$vuetify.word.check.check')"
                />
            </l-buttons>
        </v-stepper-content>
    </v-stepper>
</template>

<script>
    import LButtons from "../../layout/ButtonLayout";
    import LoadingImage from "../../components/Items/LoadingImage";
    import ErrorMessage from "../../components/Items/ErrorMessage";
    import CustomFormProperties from "../../mixins/Form/CustomFormProperties";

    export default {
        name: "OneTimePasswordForm",

        components: {
            LButtons,
            LoadingImage,
            ErrorMessage,
        },

        mixins: [
            CustomFormProperties
        ],

        data() {
            return {
                step: 1,
            }
        },

        methods: {
            close() {
                this.$store.commit('popups/removeModal')
                this.$store.commit(`${this.vuexNamespace}/resetForm`)
            },

            validate() {
                this.$store.dispatch('user/auth/settings/validateOneTimePassword')
            }
        }
    }
</script>
