<template>
    <l-auth>
        <v-card-title>
            <div class="mx-auto font-weight-bold">
                {{ $vuetify.lang.t('$vuetify.word.reset.password') }}
            </div>
        </v-card-title>
        <v-card-subtitle class="pa-4">
            <div class="text--disabled">
                {{ $vuetify.lang.t('$vuetify.text.password.reset.info') }}
            </div>
            <ul class="text--disabled">
                <li :class="{'red--text': errors.characters}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.characters') }}</li>
                <li :class="{'red--text': errors.mixedCase}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.mixed_case') }}</li>
                <li :class="{'red--text': errors.number}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.number') }}</li>
                <li :class="{'red--text': errors.symbol}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.symbol') }}</li>
            </ul>
        </v-card-subtitle>
        <v-card-text class="pb-0">
            <v-text-field
                class="pb-2"
                v-model="data.password"
                :error="error"
                :error-messages="errors.password"
                :type="show_1 ? 'text' : 'password'"
                :label="$vuetify.lang.t('$vuetify.word.password')"
                :append-icon="show_1 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                dense
                outlined
                hide-details="auto"
                @click:append="show_1 = !show_1"
            />
            <v-text-field
                v-model="data.password_confirm"
                :error="error"
                :type="show_2 ? 'text' : 'password'"
                :error-messages="errors.password_confirm"
                :append-icon="show_2 ? 'fas fa-eye' : 'fas fa-eye-slash'"
                :label="$vuetify.lang.t('$vuetify.word.confirm.password')"
                dense
                outlined
                @click:append="show_2 = !show_2"
            />
        </v-card-text>
        <v-card-actions>
            <v-btn
                block
                color="primary"
                :disabled="$loading"
                @click="send"
            >
                {{ $vuetify.lang.t('$vuetify.word.reset.password') }}
            </v-btn>
        </v-card-actions>
    </l-auth>
</template>

<script>
    import LAuth from "../../layout/Auth";

    export default {
        name: "PasswordReset",

        props: {
            token: {
                required: true,
                type: String,
            },

            encryptEmail: {
                required: true,
                type: String,
            }
        },

        components: {
            LAuth
        },

        data() {
            return {
                error: false,
                show_1: false,
                show_2: false,
                data: {
                    token: this.token,
                    user_token: this.encryptEmail,
                    password: '',
                    password_confirm: '',
                },
                errors: {},
            }
        },

        created() {
            window.addEventListener('keydown', this.enter)
        },

        beforeDestroy() {
            window.removeEventListener('keydown', this.enter);
        },

        methods: {
            send() {
                let app = this

                this.errors = {}
                this.error = false
                this.$api.call({
                    url: '/reset/password',
                    method: "post",
                    data: app.data,
                }).then((response) => {
                    window.location.href = response.data.redirect
                }).catch((error) => {
                    let errors = error.response.data.errors || {}

                    errors.password?.forEach((message) => {
                        app.error = true

                        if (message.includes('characters')) {
                            app.errors.characters = true
                        } else if (message.includes('uppercase')) {
                            app.errors.mixedCase = true
                        } else if (message.includes('number')) {
                            app.errors.number = true
                        } else if (message.includes('symbol')) {
                            app.errors.symbol = true
                        } else {
                            app.errors.password = [
                                ...app.errors.password || [],
                                message
                            ]
                        }
                    })

                    delete errors.password

                    app.errors = {
                        ...app.errors,
                        ...errors
                    }
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
