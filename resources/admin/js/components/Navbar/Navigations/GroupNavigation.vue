<template>
    <v-list-item-group
        color="primary"
    >
        <component
            :is="navigation.componentName"
            v-for="navigation in component.data.navigations"
            :key="navigation.identifier"
            :is-hidden="isHidden"
            :value="navigation"
        />
    </v-list-item-group>
</template>

<script>
    import ComponentBase from "../../Base/ComponentBase";
    import NavigationItemComponent from "./Items/NavigationItem.vue";
    import NavigationCustomItemComponent from "./Items/Custom/index.vue";
    import NavigationCreateItemComponent from "./Items/NavigationCreateItem.vue";

    export default {
        name: "GroupNavigation",

        components: {
            NavigationItemComponent,
            NavigationCreateItemComponent,
            NavigationCustomItemComponent
        },

        extends: ComponentBase,

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
