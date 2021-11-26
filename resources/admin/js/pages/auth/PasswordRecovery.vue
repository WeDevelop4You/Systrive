<template>
    <l-auth>
        <v-card-title>
            <div class="mx-auto font-weight-bold">
                {{ $vuetify.lang.t('$vuetify.word.forgot_password') }}
            </div>
        </v-card-title>
        <v-card-subtitle class="pa-4">
            <div class="text-center text--disabled">
                {{ $vuetify.lang.t('$vuetify.text.password.forgot') }}
            </div>
        </v-card-subtitle>
        <v-card-text class="pb-0">
            <v-text-field
                v-model="email"
                class="pb-2"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                outlined
                dense
                type="text"
                :error-messages="errors.email"
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
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Auth'

    export default {
        name: "PasswordRecovery",

        components: {
            LAuth
        },

        data() {
            return {
                email: '',
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
                this.$api.call({
                    url: '/password/recovery',
                    method: "post",
                    data: {
                        email: app.email
                    }
                }).then(() => {
                    app.email = ''
                }).catch((error) => {
                    app.errors = error.response.data.errors || {}
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
