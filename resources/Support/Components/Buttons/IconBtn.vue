<template>
    <tooltip
        v-slot="{tooltip}"
        :value="component.data.tooltip"
    >
        <v-hover
            v-slot="{hover}"
        >
            <v-btn
                v-bind="component.attributes"
                depressed
                @click="runAction"
                v-on="tooltip"
            >
                <icon
                    :value="component.data.icon"
                    :color="hover ? component.data.hoverColor : undefined"
                />
            </v-btn>
        </v-hover>
    </tooltip>
</template>

<script>
    import Icon from "../Misc/Icons/Icon.vue";
    import Tooltip from "../Utils/Tooltip.vue";
    import {debounce as _debounce} from "lodash";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "IconBtn",

        components: {
            Tooltip,
            Icon,
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
