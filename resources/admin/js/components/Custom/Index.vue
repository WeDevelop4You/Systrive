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

        extends: ComponentBase,

        components: {
            LocaleDropdownComponent: () => import('./LocaleDropdown.vue')
        },
    }
</script>
