<template>
    <tooltip
        v-slot="{tooltip}"
        :value="value.data.tooltip"
    >
        <v-list-item
            v-bind="value.attributes"
            :class="{'pl-2': isHidden}"
            dense
            @click="callAction(value.data.action)"
            v-on="tooltip"
        >
            <component
                :is="value.data.prepend.componentName"
                v-if="value.data.prepend"
                :value="value.data.prepend"
                :is-hidden="isHidden"
            />
            <v-list-item-content>
                <v-list-item-title v-html="value.content.title" />
            </v-list-item-content>
        </v-list-item>
    </tooltip>
</template>

<script>
    import ComponentProperties from "../../../../mixins/ComponentProperties";
    import Icon from "./NavigationItemIcon"
    import CImage from "./NavigationItemImage"
    import Tooltip from "../../../Utils/Tooltip";

    export default {
        name: "NavigationItem",

        components: {
            Icon,
            CImage,
            Tooltip
        },

        mixins: [
            ComponentProperties
        ],

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
