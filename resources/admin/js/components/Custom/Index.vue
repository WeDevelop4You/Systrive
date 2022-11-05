<template>
    <component
        :is="component.data.type"
        :value="component"
    />
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Index",

        components: {
            LocaleDropdownComponent: () => import('./LocaleDropdown.vue')
        },

        extends: ComponentBase,
    }
</script>
