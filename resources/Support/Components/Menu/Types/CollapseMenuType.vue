<template>
    <v-list-group
        no-action
        color="text--primary"
    >
        <template #activator>
            <v-list-item-icon
                v-show="component.data.icon || isHidden"
                :class="[isHidden ? 'ml-n2' : 'mr-2']"
                class="justify-center"
                style="min-width: 40px"
            >
                <icon :value="component.data.icon || defaultIcon" />
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title v-text="component.content.title" />
            </v-list-item-content>
        </template>
        <component
            :is="item.componentName"
            v-for="item in component.data.items"
            v-show="!isHidden"
            :key="item.identifier"
            :is-hidden="isHidden"
            :value="item"
        />
    </v-list-group>
</template>

<script>
    import Icon from "../../Misc/Icon.vue";
    import ComponentBase from "../../Base/ComponentBase";
    import MenuItemComponent from "../Items/MenuItem.vue";
    import Component from "../../../Helpers/Components/Component";
    import CustomMenuItemComponent from "../Items/Custom/index.vue";
    import CreateMenuItemComponent from "../Items/CreateMenuItem.vue";
    import ContentMenuItemComponent from "../Items/ContentMenuItem.vue";

    export default {
        name: "CollapseMenuType",

        components: {
            Icon,
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
        },

        data() {
            return {
                defaultIcon: new Component({
                    content: {
                        type: 'fas fa-list'
                    }
                })
            }
        }
    }
</script>
