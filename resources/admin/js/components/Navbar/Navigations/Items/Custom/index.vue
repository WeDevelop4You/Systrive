<template>
    <component
        :is="component.data.type"
        :value="component"
        :is-hidden="isHidden"
    />
</template>

<script>
    import ComponentBase from "../../../../Base/ComponentBase";

    export default {
        name: "NavigationItem",

        extends: ComponentBase,

        components: {
            DarkModeSwitchComponent: () => import('./DarkModeSwitch.vue')
        },

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
