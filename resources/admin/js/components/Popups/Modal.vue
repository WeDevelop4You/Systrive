<template>
    <v-dialog
        v-model="value.data.show"
        v-bind="value.attributes"
        :elevation="$config.elevation"
        @input="change($event)"
    >
        <card
            :value="value.data.card"
        />
    </v-dialog>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import Card from "../Overviews/Card.vue";

    export default {
        name: "Modal",

        components: {
            Card
        },

        mixins: [
            ComponentProperties
        ],

        methods: {
            change(isOpen) {
                if (!isOpen) {
                    this.$store.commit('popups/removeModal', this.value.identifier)
                }

                const action = isOpen
                    ? this.value.data.openAction
                    : this.value.data.closeAction

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
