<template>
    <tooltip
        v-slot="{tooltip}"
        :value="component.data.tooltip"
    >
        <v-btn
            v-bind="component.attributes"
            :disabled="$loading"
            :class="component.data.classes"
            depressed
            @click="$actions.call(component.data.action)"
            v-on="tooltip"
        >
            <template v-if="component.content.title">
                {{ component.content.title }}
            </template>
            <template v-else-if="component.data.component">
                <component
                    :is="component.data.component.componentName"
                    :value="component.data.component"
                />
            </template>
            <template v-else>
                <component-error small />
            </template>
        </v-btn>
    </tooltip>
</template>

<script>
    import Tooltip from "../Utils/Tooltip.vue";
    import ComponentBase from "../Base/ComponentBase";
    import ComponentError from "../ComponentError.vue";
    import TextIconComponent from "../Icons/TextIcon.vue";

    export default {
        name: "Btn",

        components: {
            Tooltip,
            ComponentError,
            TextIconComponent,
        },

        extends: ComponentBase,

        methods: {
            runDefaultAction() {
                this.$actions.call(this.component.data.action)
            }
        }
    }
</script>
