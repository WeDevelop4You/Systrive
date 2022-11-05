<template>
    <v-list
        v-bind="component.attributes"
        dense
    >
        <template v-for="(item, index) in component.data.list">
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
    import GroupNavigationComponent from "./Navigations/GroupNavigation.vue";
    import CollapseNavigationComponent from "./Navigations/CollapseNavigation.vue";

    export default {
        name: "Navbar",

        extends: ComponentBase,

        components: {
            GroupNavigationComponent,
            CollapseNavigationComponent,
        },

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
