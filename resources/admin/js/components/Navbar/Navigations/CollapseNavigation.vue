<template>
    <v-list-group
        no-action
        color="text--primary"
    >
        <template #activator>
            <v-list-item-icon
                :class="[isHidden ? 'ml-n2' : 'mr-2']"
                class="justify-center"
                style="min-width: 40px"
            >
                <icon :value="value.data.icon" />
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title v-text="value.content.title" />
            </v-list-item-content>
        </template>
        <component
            :is="navigation.componentName"
            v-for="navigation in value.data.navigations"
            v-show="!isHidden"
            :key="navigation.identifier"
            :is-hidden="isHidden"
            :value="navigation"
        />
    </v-list-group>
</template>

<script>
    import Icon from "../../Icons/Icon.vue";
    import NavigationItem from "./Items/NavigationItem.vue";
    import ComponentProperties from "../../../mixins/ComponentProperties";
    import NavigationCustomItem from "./Items/NavigationCustomItem.vue";

    export default {
        name: "CollapseNavigation",

        components: {
            Icon,
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
