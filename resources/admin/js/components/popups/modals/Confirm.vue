<template>
    <v-card>
        <v-card-title
            class="text-h5"
            v-text="data.title"
        />
        <v-card-text v-text="data.text" />
        <v-card-actions>
            <v-spacer />
            <v-btn
                text
                @click="cancel"
                v-text="data.cancel_text || $vuetify.lang.t('$vuetify.word.cancel.cancel')"
            />
            <v-btn
                color="primary"
                @click="accept"
                v-text="data.accept_text || $vuetify.lang.t('$vuetify.word.accept.accept')"
            />
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "Confirm",

        props: {
            data: {
                required: true,
                type: Object,
            }
        },

        methods: {
            accept() {
                let app = this

                this.$api.call({
                    url: app.data.accept_url,
                    method:  app.data.accept_method || "POST",
                }).finally(() => {
                    app.$emit('close')
                })
            },

            cancel() {
                let app = this

                this.$api.call({
                    url: app.data.cancel_url,
                    method: "DELETE",
                }).finally(() => {
                    app.$emit('close')
                })
            }
        }
    }
</script>
