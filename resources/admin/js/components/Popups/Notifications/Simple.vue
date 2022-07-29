<template>
    <v-alert
        v-model="value.data.show"
        v-bind="value.attributes"
        border="left"
        colored-border
        transition="scale-transition"
    >
        <div v-html="value.content.text" />
        <template
            v-if="value.data.dismissible"
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
            value: {
                type: Object,
                required: true
            },
        },

        methods: {
            remove() {
                this.$store.commit('popups/removeNotification', this.value.identifier)
            }
        }
    }
</script>
