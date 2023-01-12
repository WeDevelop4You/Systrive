<template>
    <component
        :is="component.data.type"
        :value="component"
    />
</template>

<script>
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "CustomInput",

        components: {
            SelectColumnInputComponent: () => import('./Custom/SelectColumnInput.vue'),
            PermissionUserInputComponent: () => import('./Custom/PermissionUserInput.vue'),
            PermissionRoleInputComponent: () => import('./Custom/PermissionRoleInput.vue'),
        },

        extends: ComponentBase
    }
</script>
