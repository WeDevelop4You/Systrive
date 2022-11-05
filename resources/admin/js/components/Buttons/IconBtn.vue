<template>
    <tooltip
        v-slot="{tooltip}"
        :value="component.data.tooltip"
    >
        <v-hover v-slot="{hover}">
            <v-btn
                v-bind="component.attributes"
                :class="component.data.classes"
                depressed
                @click="$actions.call(component.data.action)"
                v-on="tooltip"
            >
                <icon
                    :value="component.data.icon"
                    :hover-color="hover ? component.data.hoverColor : undefined"
                />
            </v-btn>
        </v-hover>
    </tooltip>
</template>

<script>
    import Icon from "../Icons/Icon.vue";
    import Tooltip from "../Utils/Tooltip.vue";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "IconBtn",

        extends: ComponentBase,

        components: {
            Tooltip,
            Icon,
        },

        methods: {
            runDefaultAction() {
                this.$actions.call(this.component.data.action)
            }
        }
    }
</script>
