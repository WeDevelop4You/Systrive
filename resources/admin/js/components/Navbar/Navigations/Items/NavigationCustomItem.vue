<template>
    <component
        :is="value.data.type"
        :value="value"
        :is-hidden="isHidden"
    />
</template>

<script>
    import ComponentProperties from "../../../../mixins/ComponentProperties";


    export default {
        name: "NavigationItem",

        components: {
            DarkModeSwitch: () => import('./Custom/DarkModeSwitch.vue')
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
