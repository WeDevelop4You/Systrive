<template>
    <tooltip
        v-slot="{tooltip}"
        :value="value.data.tooltip"
    >
        <v-btn
            v-bind="value.attributes"
            :disabled="$loading"
            :class="value.data.classes"
            depressed
            @click="$actions.call(value.data.action)"
            v-on="tooltip"
        >
            <template v-if="value.content.title">
                {{ value.content.title }}
            </template>
            <template v-else>
                <component
                    :is="value.data.component.componentName"
                    :value="value.data.component"
                />
            </template>
        </v-btn>
    </tooltip>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import tooltip from "../Utils/Tooltip.vue";

    export default {
        name: "Btn",

        components: {
            tooltip,
            TextIcon: () => import(/* webpackChunkName: "components/icons/text_icon" */ '../Icons/TextIcon')
        },

        mixins: [
            ComponentProperties,
        ],

        methods: {
            runDefaultAction() {
                this.$actions.call(this.value.data.action)
            }
        }
    }
</script>
