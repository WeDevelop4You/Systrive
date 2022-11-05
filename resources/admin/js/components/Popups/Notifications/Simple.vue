<template>
    <v-alert
        v-model="component.data.show"
        v-bind="component.attributes"
        border="left"
        colored-border
        transition="scale-transition"
    >
        <div v-html="component.content.text" />
        <template
            v-if="component.data.dismissible"
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
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "Simple",

        extends: ComponentBase,

        methods: {
            remove() {
                this.$store.commit('popups/removeNotification', this.component.identifier)
            }
        }
    }
</script>
