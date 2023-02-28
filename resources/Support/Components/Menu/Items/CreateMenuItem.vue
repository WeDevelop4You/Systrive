<template>
    <tooltip
        v-slot="{on: onTooltip}"
        :value="component.data.tooltip"
    >
        <v-list-item
            v-show="!isHidden"
            v-bind="component.attributes"
            dense
            class="pl-4"
            @click="$actions.call(component.data.action)"
            v-on="onTooltip"
        >
            <icon
                :value="icon"
                center
                class="mx-auto"
            />
        </v-list-item>
    </tooltip>
</template>

<script>
    import Icon from "../../Misc/Icon.vue";
    import Tooltip from "../../Utils/Tooltip.vue";
    import Component from "../../../Helpers/Components/Component";
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "NavigationCreateItem",

        components: {
            Icon,
            Tooltip
        },

        extends: ComponentBase,

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
