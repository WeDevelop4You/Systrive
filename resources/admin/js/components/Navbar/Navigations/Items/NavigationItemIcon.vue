<template>
    <v-list-item-icon
        :class="[center ? 'mx-auto': {'mr-2': !isHidden}]"
        class="justify-center"
        style="min-width: 40px"
    >
        <icon :value="component" />
    </v-list-item-icon>
</template>

<script>
    import Icon from "../../../Icons/Icon.vue";
    import ComponentBase from "../../../Base/ComponentBase";

    export default {
        name: "NavigationItemIcon",

        extends: ComponentBase,

        components: {
            Icon
        },

        props: {
            isHidden: {
                type: Boolean,
                default: false
            },

            center: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
