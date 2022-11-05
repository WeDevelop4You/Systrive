<template>
    <tooltip
        v-slot="{tooltip}"
        :value="component.data.tooltip"
    >
        <v-list-item
            v-bind="component.attributes"
            :class="{'pl-2': isHidden}"
            dense
            @click="$actions.call(component.data.action)"
            v-on="tooltip"
        >
            <component
                :is="component.data.prepend.componentName"
                v-if="component.data.prepend"
                :value="component.data.prepend"
                :is-hidden="isHidden"
            />
            <v-list-item-content>
                <v-list-item-title v-text="component.content.title" />
            </v-list-item-content>
        </v-list-item>
    </tooltip>
</template>

<script>
    import Tooltip from "../../../Utils/Tooltip.vue";
    import IconComponent from "./NavigationItemIcon.vue"
    import ImageComponent from "./NavigationItemImage.vue"
    import ComponentBase from "../../../Base/ComponentBase";

    export default {
        name: "NavigationItem",

        extends: ComponentBase,

        components: {
            Tooltip,
            IconComponent,
            ImageComponent,
        },

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
