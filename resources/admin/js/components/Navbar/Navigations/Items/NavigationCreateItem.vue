<template>
    <tooltip
        v-slot="{tooltip}"
        :value="component.data.tooltip"
    >
        <v-list-item
            v-show="!isHidden"
            v-bind="component.attributes"
            dense
            class="pl-4"
            @click="$actions.call(component.data.action)"
            v-on="tooltip"
        >
            <icon
                :value="icon"
                center
                class="mx-auto"/>
        </v-list-item>
    </tooltip>
</template>

<script>
    import Icon from "./NavigationItemIcon.vue";
    import Tooltip from "../../../Utils/Tooltip.vue";
    import Component from "../../../../helpers/Components/Component";
    import ComponentBase from "../../../Base/ComponentBase";

    export default {
        name: "NavigationCreateItem",

        extends: ComponentBase,

        components: {
            Icon,
            Tooltip
        },

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                icon: new Component({
                    content: {
                        type: 'fas fa-plus'
                    }
                })
            }
        }
    }
</script>
