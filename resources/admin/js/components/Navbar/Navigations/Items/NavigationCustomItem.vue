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
            DarkModeSwitch: () => import(/* webpackChunkName: "components/navbar/navigations/items/custom/dark_mode_switch" */ './Custom/DarkModeSwitch')
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
