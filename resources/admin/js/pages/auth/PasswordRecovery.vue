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
                    class="mx-auto font-weight-bold"
                    v-text="$vuetify.lang.t('$vuetify.word.forgot_password')"
                />
            </v-card-title>
            <v-card-subtitle class="pa-4">
                <div class="text-center text--disabled">
                    {{ $vuetify.lang.t('$vuetify.text.password.forgot') }}
                </div>
            </v-card-subtitle>
            <v-card-text class="pb-0">
                <v-text-field
                    v-model="email"
                    :error-messages="errors.email"
                    :class="{'pb-2': !errors.email}"
                    :label="$vuetify.lang.t('$vuetify.word.email')"
                    dense
                    outlined
                    type="email"
                    hide-details="auto"
                />
            </v-card-text>
            <v-card-actions class="px-4">
                <v-btn
                    block
                    color="primary"
                    :disabled="$loading"
                    @click="send"
                >
                    {{ $vuetify.lang.t('$vuetify.word.send_email') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </l-auth>
</template>

<script>
    import {mapGetters} from "vuex";
    import LAuth from '../../layout/Auth'
    import SvgLogoLine from '../../components/svg/LogoLine'

    export default {
        name: "PasswordRecovery",

        components: {
            LAuth,
            SvgLogoLine
        },

        data() {
            return {
                email: '',
            }
        },

        computed: {
            ...mapGetters({
                errors: 'guest/errors'
            })
        },

        created() {
            window.addEventListener('keydown', this.enter)
        },

        methods: {
            send() {
                let app = this

                this.$store.dispatch('guest/sendEmail', this.email).then((response) => {
                    if (response) app.email = ''
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
