<template>
    <v-card :max-width="data.max_width">
        <v-card-title
            class="text-h5"
            v-text="data.title"
        />
        <v-card-text>
            <component
                :is="data.form_component"
                v-model="data"
                :errors="errors"
            />
        </v-card-text>
        <v-card-actions>
            <v-spacer />
            <v-btn
                text
                @click="cancel"
                v-text="data.cancel_text || $vuetify.lang.t('$vuetify.word.cancel.cancel')"
            />
            <v-btn
                color="primary"
                @click="save"
                v-text="data.save_text || $vuetify.lang.t('$vuetify.word.save')"
            />
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "Form",

        components: {
            Company: () => import(/* webpackChunkName: "layout/forms/company/complete" */ '../../../layout/forms/company/Complete'),
        },

        props: {
            data: {
                required: true,
                type: Object,
            }
        },

        data() {
            return {
                errors: {}
            }
        },

        methods: {
            save() {
                let app = this

                this.$api.call({
                    url: app.data.request_url,
                    method: app.data.request_method || "POST",
                    data: app.data
                }).then(() => {
                    app.$emit('close')
                }).catch((error) => {
                    app.errors = error.response.data.errors || {}
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
