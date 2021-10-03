<template>
    <l-auth>
        <v-card-title>
            <div class="mx-auto font-weight-bold">{{ $vuetify.lang.t('$vuetify.word.forgot_password') }}</div>
        </v-card-title>
        <v-card-subtitle class="pa-4">
            <div class="text-center text--disabled">{{ $vuetify.lang.t('$vuetify.text.password.forgot') }}</div>
        </v-card-subtitle>
        <v-card-text class="pb-0">
            <v-text-field v-model="email" class="pb-2" :label="$vuetify.lang.t('$vuetify.word.email')" outlined dense type="text" :error-messages="error_message.email"></v-text-field>
        </v-card-text>
        <v-card-actions class="px-4">
            <v-btn block color="primary" v-on:click="send" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.sent_email') }}</v-btn>
        </v-card-actions>
    </l-auth>
</template>

<script>
    import LAuth from '../../layout/Auth'

    export default {
        name: "RecoverPassword",

        data() {
            return {
                email: '',
                error_message: {},
            }
        },

        components: {
            LAuth
        },

        created() {
            window.addEventListener('keydown', this.enter)
        },

        methods: {
            send() {

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
