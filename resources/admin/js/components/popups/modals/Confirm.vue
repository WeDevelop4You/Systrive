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
                v-for="(button, index) in data.buttons"
                :key="index"
                :color="button.color"
                :text="button.type === 'text'"
                @click="action(button.request_url, button.request_method)"
                v-text="button.title"
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
            action(url, method) {
                let app = this

                this.$api.call({
                    url: url,
                    method: method,
                }).finally(() => {
                    app.$emit('close')
                })
            },
        }
    }
</script>
