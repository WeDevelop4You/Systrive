<template>
    <l-auth>
        <v-card-title>
            <div class="mx-auto font-weight-bold">{{ $vuetify.lang.t('$vuetify.word.reset.password') }}</div>
        </v-card-title>
        <v-card-subtitle class="pa-4">
            <div class="text--disabled">{{ $vuetify.lang.t('$vuetify.text.password.reset.info') }}</div>
            <ul class="text--disabled">
                <li>{{ $vuetify.lang.t('$vuetify.text.password.reset.list.characters') }}</li>
                <li>{{ $vuetify.lang.t('$vuetify.text.password.reset.list.uppercase') }}</li>
                <li>{{ $vuetify.lang.t('$vuetify.text.password.reset.list.number') }}</li>
                <li>{{ $vuetify.lang.t('$vuetify.text.password.reset.list.symbol') }}</li>
            </ul>
        </v-card-subtitle>
        <v-card-text class="pb-0">
            <v-text-field class="pb-2" v-model="password.password" :label="$vuetify.lang.t('$vuetify.word.password')" outlined dense :type="show_1 ? 'text' : 'password'" hide-details="auto" :error="error" :error-messages="error_message.password" :append-icon="show_1 ? 'fas fa-eye' : 'fas fa-eye-slash'" @click:append="show_1 = !show_1"></v-text-field>
            <v-text-field v-model="password.password_confirm" :label="$vuetify.lang.t('$vuetify.word.confirm.password')" outlined dense :type="show_2 ? 'text' : 'password'" :error="error" :error-messages="error_message.password_confirm" :append-icon="show_2 ? 'fas fa-eye' : 'fas fa-eye-slash'" @click:append="show_2 = !show_2"></v-text-field>
        </v-card-text>
        <v-card-actions>
            <v-btn block color="primary" v-on:click="send" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.reset.password') }}</v-btn>
        </v-card-actions>
    </l-auth>
</template>

<script>
    import LAuth from "../../layout/Auth";

    export default {
        name: "PasswordReset",

        data() {
            return {
                error: false,
                show_1: false,
                show_2: false,
                password: {
                    password: '',
                    password_confirm: '',
                },
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
