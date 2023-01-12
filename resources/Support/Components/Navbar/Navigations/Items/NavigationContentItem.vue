<template>
    <tooltip
        v-slot="{tooltip}"
        :value="component.data.tooltip"
    >
        <v-list-item
            v-show="!isHidden"
            v-bind="component.attributes"
            :ripple="false"
            dense
            inactive
            class="pl-4 text--secondary"
            v-on="tooltip"
        >
            <span
                class="mx-auto"
                v-text="component.content.title"
            />
        </v-list-item>
    </tooltip>
</template>

<script>
    import Tooltip from "../../../Utils/Tooltip.vue";
    import ComponentBase from "../../../Base/ComponentBase";

    export default {
        name: "NavigationCreateItem",

        components: {
            Tooltip
        },

        extends: ComponentBase,

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
