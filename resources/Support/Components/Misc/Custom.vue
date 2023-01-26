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
            CategoryComponent: () => import('./Custom/Category.vue'),
            LogoCardHeaderComponent: () => import('./Custom/LogoCardHeader.vue'),
            LocaleDropdownComponent: () => import('./Custom/LocaleDropdown.vue'),
            SourceExpansionComponent: () => import('./Custom/SourceExpansion.vue'),
            PasswordRequirementsComponent: () => import('./Custom/PasswordRequirements.vue')
        },

        extends: ComponentBase,
    }
</script>
