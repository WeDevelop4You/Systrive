<template>
    <v-dialog
        v-model="component.data.show"
        v-bind="component.attributes"
        :elevation="$config.elevation"
        @input="change($event)"
    >
        <card
            :value="component.data.card"
        />
    </v-dialog>
</template>

<script>
    import Card from "../Overviews/Card.vue";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Modal",

        extends: ComponentBase,

        components: {
            Card
        },

        methods: {
            change(isOpen) {
                if (!isOpen) {
                    this.$store.commit('popups/removeModal', this.component.identifier)
                }

                const action = isOpen
                    ? this.component.data.openAction
                    : this.component.data.closeAction

                if (action) {
                    this.$actions.call(action)
                    // const promise = this.$actions.call(action)

                    // if (this.$actions.returnIsPromise(promise)) {
                    //     promise.catch(() => {})
                    // }
                }
            }
        }
    }
</script>
