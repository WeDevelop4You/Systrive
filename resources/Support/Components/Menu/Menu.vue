<template>
    <v-list
        v-bind="component.attributes"
        dense
    >
        <template v-for="(item, index) in component.data.items">
            <template v-if="item.subheader">
                <v-subheader
                    v-show="!isHidden"
                    :key="index"
                    class="mb-1"
                    style="height: 20px"
                >
                    {{ item.subheader }}
                </v-subheader>
            </template>
            <template v-else-if="item.divider">
                <v-divider
                    :key="index"
                    class="my-1"
                />
            </template>
            <template v-else>
                <component
                    :is="item.componentName"
                    :key="index"
                    :value="item"
                    :is-hidden="isHidden"
                />
            </template>
        </template>
    </v-list>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";
    import GroupMenuTypeComponent from "./Types/GroupMenuType.vue";
    import CollapseMenuTypeComponent from "./Types/CollapseMenuType.vue";

    export default {
        name: "Menu",

        components: {
            GroupMenuTypeComponent,
            CollapseMenuTypeComponent,
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
