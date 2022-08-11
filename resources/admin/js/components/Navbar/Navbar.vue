<template>
    <v-list
        v-bind="value.attributes"
        dense
    >
        <template v-for="(item, index) in value.data.list">
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
    import ComponentProperties from "../../mixins/ComponentProperties";
    import GroupNavigation from "./Navigations/GroupNavigation.vue";
    import CollapseNavigation from "./Navigations/CollapseNavigation.vue";

    export default {
        name: "Navbar",

        components: {
            GroupNavigation,
            CollapseNavigation,
        },

        mixins: [
            ComponentProperties
        ],

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
