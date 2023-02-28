<template>
    <v-menu v-bind="component.attributes">
        <template #activator="{on: onMenu}">
            <v-tooltip
                v-bind="tooltip.attributes"
                :disabled="!tooltip.content.text"
            >
                <template #activator="{on: onTooltip}">
                    <v-btn
                        v-bind="button.attributes"
                        :disabled="$loading"
                        depressed
                        v-on="{...onMenu, ...onTooltip}"
                    >
                        <template v-if="button.data.content.length > 0">
                            <component
                                :is="item.componentName"
                                v-for="(item, index) in button.data.content"
                                :key="index"
                                :value="item"
                            />
                        </template>
                        <template v-else>
                            <component-error small />
                        </template>
                    </v-btn>
                </template>
                {{ tooltip.content.text }}
            </v-tooltip>
        </template>
        <Menu :value="component.data.menu" />
    </v-menu>
</template>

<script>
    import Btn from "./Btn.vue";
    import Menu from "../Menu/Menu.vue";
    import IconComponent from "../Misc/Icon.vue";
    import StringComponent from "../Misc/String.vue";
    import ComponentBase from "../Base/ComponentBase";
    import ComponentError from "../ComponentError.vue";
    import Component from "../../Helpers/Components/Component";

    export default {
        name: "DropdownBtn",

        components: {
            Menu,
            Btn,
            IconComponent,
            ComponentError,
            StringComponent,
        },

        extends: ComponentBase,

        data() {
            return {
                button: new Component(this.value.data.button),
                tooltip: new Component(this.value.data.button.data.tooltip || {})
            }
        },
    }
</script>