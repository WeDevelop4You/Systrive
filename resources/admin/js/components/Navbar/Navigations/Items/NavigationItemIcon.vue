<template>
    <v-list-item-icon
        :class="{'mr-2': !isHidden}"
        class="justify-center"
        style="min-width: 40px"
    >
        <icon :value="value" />
    </v-list-item-icon>
</template>

<script>
    import ComponentProperties from "../../../../mixins/ComponentProperties";
    import Icon from "../../../Icons/Icon";

    export default {
        name: "NavigationItemIcon",

        components: {
            Icon
        },

        mixins: [
            ComponentProperties
        ],

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
