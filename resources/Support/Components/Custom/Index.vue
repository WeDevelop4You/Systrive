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
            CategoryComponent: () => import('./Category.vue'),
            LogoCardHeaderComponent: () => import('./LogoCardHeader.vue'),
            LocaleDropdownComponent: () => import('./LocaleDropdown.vue'),
            SourceExpansionComponent: () => import('./SourceExpansion.vue'),
            PasswordRequirementsComponent: () => import('./PasswordRequirements.vue')
        },

        extends: ComponentBase,
    }
</script>
