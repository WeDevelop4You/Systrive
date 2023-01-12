<template>
    <v-row
        v-bind="component.attributes"
        no-gutters
        class="align-center justify-end"
    >
        <component
            :is="btn.componentName"
            v-for="btn in component.data.buttons"
            :key="btn.identifier"
            :value="btn"
        />
    </v-row>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "MultipleBtn",

        components: {
            BtnComponent: () => import('./Btn.vue'),
            IconBtnComponent: () => import('./IconBtn.vue'),
        },

        extends: ComponentBase,
    }
</script>
