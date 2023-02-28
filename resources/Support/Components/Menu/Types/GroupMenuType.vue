<template>
    <v-list-item-group
        color="primary"
    >
        <component
            :is="item.componentName"
            v-for="item in component.data.items"
            :key="item.identifier"
            :is-hidden="isHidden"
            :value="item"
        />
    </v-list-item-group>
</template>

<script>
    import ComponentBase from "../../Base/ComponentBase";
    import MenuItemComponent from "../Items/MenuItem.vue";
    import CreateMenuItemComponent from "../Items/CreateMenuItem.vue";
    import CustomMenuItemComponent from "../Items/Custom/index.vue";
    import ContentMenuItemComponent from "../Items/ContentMenuItem.vue";

    export default {
        name: "GroupMenuType",

        components: {
            MenuItemComponent,
            CreateMenuItemComponent,
            CustomMenuItemComponent,
            ContentMenuItemComponent
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
