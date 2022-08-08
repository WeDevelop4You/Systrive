<template>
    <tooltip
        v-slot="{tooltip}"
        :value="value.data.tooltip"
    >
        <v-hover v-slot="{hover}">
            <v-btn
                v-bind="value.attributes"
                :class="value.data.classes"
                depressed
                @click="$actions.call(value.data.action)"
                v-on="tooltip"
            >
                <icon
                    :value="value.data.icon"
                    :color="hover ? value.data.hoverColor : undefined"
                />
            </v-btn>
        </v-hover>
    </tooltip>
</template>

<script>
    import Icon from "../Icons/Icon.vue";
    import ComponentProperties from "../../mixins/ComponentProperties";
    import Tooltip from "../Utils/Tooltip.vue";

    export default {
        name: "IconBtn",

        components: {
            Tooltip,
            Icon,
        },

        mixins: [
            ComponentProperties
        ],

        methods: {
            runDefaultAction() {
                this.$actions.call(this.value.data.action)
            }
        }
    }
</script>
