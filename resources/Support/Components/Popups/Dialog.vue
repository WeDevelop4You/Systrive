<template>
    <v-dialog
        v-model="component.data.show"
        v-bind="component.attributes"
        :elevation="$config.elevation"
        @input="change($event)"
    >
        <component
            :is="component.data.modal.componentName"
            :value="component.data.modal"
        />
    </v-dialog>
</template>

<script>
    import CardComponent from "../Overviews/Card.vue";
    import ComponentBase from "../Base/ComponentBase";
    import VerticalStepperComponent from "../Overviews/Steppers/VerticalStepper.vue";

    export default {
        name: "Dialog",

        components: {
            CardComponent,
            VerticalStepperComponent,
        },

        extends: ComponentBase,

        watch: {
            'component.data.show'(value) {
                this.runAction(value)
            }
        },

        methods: {
            change(value) {
                if (!value) {
                    this.$store.commit('popups/removeModal', this.component.identifier)
                }

                this.runAction(value)
            },

            runAction(value) {
                const action = value
                    ? this.component.data.openAction
                    : this.component.data.closeAction

                if (action) {
                    this.$actions.call(action)
                }
            }
        }
    }
</script>
