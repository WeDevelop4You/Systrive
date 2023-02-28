<template>
    <tooltip
        v-slot="{on: onTooltip}"
        :value="component.data.tooltip"
    >
        <v-hover v-slot="{hover: onHover}">
            <v-btn
                v-bind="component.attributes"
                :disabled="$loading"
                depressed
                @click="runAction"
                v-on="onTooltip"
            >
                <template v-if="component.data.content.length > 0">
                    <component
                        :is="item.componentName"
                        v-for="(item, index) in component.data.content"
                        :key="index"
                        :value="item"
                        :color="onHover ? component.data.hoverColor : undefined"
                    />
                </template>
                <template v-else>
                    <component-error small />
                </template>
            </v-btn>
        </v-hover>
    </tooltip>
</template>

<script>
    import Tooltip from "../Utils/Tooltip.vue";
    import IconComponent from "../Misc/Icon.vue";
    import StringComponent from "../Misc/String.vue";
    import ComponentBase from "../Base/ComponentBase";
    import ComponentError from "../ComponentError.vue";
    import {debounce as _debounce} from "lodash";

    export default {
        name: "Btn",

        components: {
            Tooltip,
            IconComponent,
            ComponentError,
            StringComponent,
        },

        extends: ComponentBase,

        data() {
            return {
                action: _debounce(() => {
                    this.$actions.call(this.component.data.action)
                }, 500, {
                    'leading': true,
                    'trailing': false
                })
            }
        },

        methods: {
            runAction() {
                if (!this.$loading) {
                    this.action()
                }
            },

            runDefaultAction() {
                this.$actions.call(this.component.data.action)
            }
        }
    }
</script>
