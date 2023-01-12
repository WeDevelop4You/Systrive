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
            :is="navigation.componentName"
            v-for="navigation in component.data.navigations"
            v-show="!isHidden"
            :key="navigation.identifier"
            :is-hidden="isHidden"
            :value="navigation"
        />
    </v-list-group>
</template>

<script>
    import Icon from "../../Misc/Icons/Icon.vue";
    import ComponentBase from "../../Base/ComponentBase";
    import Component from "../../../helpers/Components/Component";
    import NavigationItemComponent from "./Items/NavigationItem.vue";
    import NavigationCustomItemComponent from "./Items/Custom/index.vue";
    import NavigationCreateItemComponent from "./Items/NavigationCreateItem.vue";
    import NavigationContentItemComponent from "./Items/NavigationContentItem.vue";

    export default {
        name: "CollapseNavigation",

        components: {
            Icon,
            NavigationItemComponent,
            NavigationCreateItemComponent,
            NavigationCustomItemComponent,
            NavigationContentItemComponent
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
