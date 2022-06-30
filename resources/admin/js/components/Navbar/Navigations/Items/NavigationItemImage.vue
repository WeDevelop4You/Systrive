<template>
    <v-list-item-avatar
        :class="{'mr-2': !isHidden}"
        :max-width="value.attributes.maxWidth"
        :max-height="value.attributes.maxHeight"
        class="my-0"
    >
        <c-image
            class="mx-auto"
            :value="value"
        />
    </v-list-item-avatar>
</template>

<script>
    import CImage from "../../../Images/Image"
    import ComponentProperties from "../../../../mixins/ComponentProperties";

    export default {
        name: "NavigationItemIcon",

        components: {
            CImage
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
