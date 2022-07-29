<template>
    <v-list-item-group
        color="primary"
    >
        <component
            :is="navigation.componentName"
            v-for="navigation in value.data.navigations"
            :key="navigation.identifier"
            :is-hidden="isHidden"
            :value="navigation"
        />
    </v-list-item-group>
</template>

<script>
    import ComponentProperties from "../../../mixins/ComponentProperties";
    import NavigationItem from "./Items/NavigationItem";
    import NavigationCustomItem from "./Items/NavigationCustomItem";

    export default {
        name: "GroupNavigation",

        components: {
            NavigationItem,
            NavigationCustomItem
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
