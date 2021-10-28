<template>
    <v-alert
        :value="show"
        :icon="message.icon"
        :type="message.type"
        :color="message.color"
        :elevation="$config.elevation"
        border="left"
        colored-border
        transition="scale-transition"
    >
        <div v-html="message.text" />
        <template
            v-if="dismissible"
            #close
        >
            <v-btn
                class="v-alert__dismissible"
                small
                icon
                @click="remove"
            >
                <v-icon>fas fa-times</v-icon>
            </v-btn>
        </template>
    </v-alert>
</template>

<script>
    export default {
        name: "Simple",

        props: {
            uuid: {
                type: String,
                required: true
            },

            message: {
                type: Object,
                required: true
            },

            dismissible: {
                type: Boolean,
                Required: true,
                default: false,
            }
        },

        data() {
            return {
                show: false,
            }
        },

        mounted() {
            this.show = true
        },

        methods: {
            remove() {
                this.$store.commit('notifications/removePopup', this.uuid)
            }
        }
    }
</script>
