<template>
    <v-list-item-avatar
        :class="{'mr-2': !isHidden}"
        :max-width="component.attributes.maxWidth"
        :max-height="component.attributes.maxHeight"
        class="my-0"
    >
        <c-image
            class="mx-auto"
            :value="component"
        />
    </v-list-item-avatar>
</template>

<script>
    import CImage from "../../../Images/Image.vue"
    import ComponentBase from "../../../Base/ComponentBase";

    export default {
        name: "NavigationItemIcon",

        extends: ComponentBase,

        components: {
            CImage
        },

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
