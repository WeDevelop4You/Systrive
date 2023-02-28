<template>
    <v-row
        v-bind="component.attributes"
        no-gutters
        class="align-center justify-end"
    >
        <component
            :is="item.componentName"
            v-for="item in component.data.items"
            :key="item.identifier"
            :value="item"
        />
    </v-row>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Wrapper",

        components: {
            BtnComponent: () => import('../Buttons/Btn.vue'),
            DropdownBtnComponent: () => import('../Buttons/DropdownBtn.vue'),
        },

        extends: ComponentBase,
    }
</script>
