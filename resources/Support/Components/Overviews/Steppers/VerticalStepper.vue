<template>
    <v-stepper
        v-model="step"
        v-bind="component.attributes"
        :elevation="$config.elevation"
        vertical
    >
        <component
            :is="component.data.header.componentName"
            v-if="component.data.hasHeader"
            :value="component.data.header"
        />
        <template
            v-for="(stepper, index) in component.data.items"
        >
            <v-stepper-step
                :key="`step_${index}`"
                :step="stepper.data.step"
                :complete="step > stepper.data.step"
            >
                {{ stepper.content.title }}
            </v-stepper-step>
            <v-stepper-content
                :key="`content_${index}`"
                :step="stepper.data.step"
            >
                <row :value="stepper.data.content" />
            </v-stepper-content>
        </template>
    </v-stepper>
</template>

<script>
    import Row from "../../Layouts/Row.vue";
    import CardHeaderComponent from "../../Misc/CardHeader.vue";
    import MainComponentBase from "../../Base/MainComponentBase";

    export default {
        name: "VerticalStepper",

        components: {
            Row,
            CardHeaderComponent,
        },

        extends: MainComponentBase,

        computed: {
            step: {
                get() {
                    return this.$store.getters[`${this.component.data.vuexNamespace}/step`]
                },

                set(value) {
                    this.$store.commit(`${this.component.data.vuexNamespace}/setStep`, value)
                }
            }
        }
    }
</script>
