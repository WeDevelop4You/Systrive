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

        components: {
            DarkModeSwitchComponent: () => import('./DarkModeSwitch.vue')
        },

        extends: ComponentBase,

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
