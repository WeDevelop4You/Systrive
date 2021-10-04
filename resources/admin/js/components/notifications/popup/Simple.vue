<template>
    <v-alert :value="show" border="left" :icon="message.icon" :dismissible="dismissible" @input="remove()" colored-border :type="message.type" transition="scale-transition" :elevation="$config.elevation">
        <div v-html="message.text"></div>
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
                show: false
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
