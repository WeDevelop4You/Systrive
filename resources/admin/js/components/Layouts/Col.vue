<template>
    <v-col v-bind="value.attributes">
        <component
            :is="value.data.component.componentName"
            :value="value.data.component"
        />
    </v-col>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import ComponentError from "../ComponentError.vue";
    import SkeletonCard from "../../layout/Skeletons/SkeletonCard.vue";
    import SkeletonDataTable from "../../layout/Skeletons/SkeletonDataTable.vue";
    import LazyImportProperties from "../../mixins/LazyImportProperties";

    export default {
        name: "Col",

        components: {
            Row: () => import('./Row.vue'),
            Btn: () => import('../Buttons/Btn.vue'),
            Content: () => import('../Items/Text.vue'),
            Custom: () => import('../Custom/Index.vue'),
            IconBtn: () => import('../Buttons/IconBtn.vue'),
            MultipleBtn: () => import('../Buttons/MultipleBtn.vue'),

            Card: () => ({
                component: import('../Overviews/Card.vue'),
                loading: SkeletonCard,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
            Table: () => ({
                component: import('../Overviews/Table.vue'),
                loading: SkeletonDataTable,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
            Page: () => ({
                component: import('../Overviews/Page.vue'),
                ...LazyImportProperties
            }),

            TextInput: () => import('../Forms/InputTypes/TextInput.vue'),
            SelectInput: () => import('../Forms/InputTypes/SelectInput.vue'),
            CodeEditorInput: () => import('../Forms/InputTypes/CodeEditorInput.vue'),
        },

        mixins: [
            ComponentProperties
        ]
    }
</script>
