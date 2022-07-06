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
    import ComponentError from "../ComponentError";
    import SkeletonCard from "../../layout/Skeletons/SkeletonCard";
    import SkeletonDataTable from "../../layout/Skeletons/SkeletonDataTable";
    import LazyImportProperties from "../../mixins/LazyImportProperties";

    export default {
        name: "Col",

        components: {
            Row: () => import(/* webpackChunkName: "components/layouts/row" */ './Row'),
            Btn: () => import(/* webpackChunkName: "components/buttons/btn" */ '../Buttons/Btn'),
            Content: () => import(/* webpackChunkName: "components/items/text" */ '../Items/Text'),
            Custom: () => import(/* webpackChunkName: "components/custom/index" */ '../Custom/Index'),
            IconBtn: () => import(/* webpackChunkName: "components/buttons/icon_btn" */ '../Buttons/IconBtn'),
            MultipleBtn: () => import(/* webpackChunkName: "components/buttons/multiple_btn" */ '../Buttons/MultipleBtn'),

            Card: () => ({
                component: import(/* webpackChunkName: "components/overviews/card" */ '../Overviews/Card'),
                loading: SkeletonCard,
                delay: 0,
                error: ComponentError,
                timeout: 5000
            }),
            Table: () => ({
                component: import(/* webpackChunkName: "components/overviews/table" */ '../Overviews/Table'),
                loading: SkeletonDataTable,
                delay: 0,
                error: ComponentError,
                timeout: 5000
            }),
            Page: () => ({
                component: import(/* webpackChunkName: "components/page" */ '../Overviews/Page'),
                ...LazyImportProperties
            }),

            TextInput: () => import(/* webpackChunkName: "components/forms/inputs/text_input" */ '../Forms/InputTypes/TextInput'),
            SelectInput: () => import(/* webpackChunkName: "components/forms/inputs/select_input" */ '../Forms/InputTypes/SelectInput'),
            CodeEditorInput: () => import(/* webpackChunkName: "components/forms/inputs/code_editor_input" */ '../Forms/InputTypes/CodeEditorInput'),
        },

        mixins: [
            ComponentProperties
        ]
    }
</script>
