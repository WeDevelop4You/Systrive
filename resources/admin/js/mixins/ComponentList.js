import SkeletonCard from "../layout/Skeletons/SkeletonCard.vue";
import ComponentError from "../components/ComponentError.vue";
import SkeletonList from "../layout/Skeletons/SkeletonList.vue";
import LazyImportConfig from "../helpers/LazyImportConfig";
import SkeletonDataTable from "../layout/Skeletons/SkeletonDataTable.vue";

export default {
    components: {
        RowComponent: () => import('../components/Layouts/Row.vue'),
        IconComponent: () => import('../components/Icons/Icon.vue'),
        CustomComponent: () => import('../components/Custom/Index.vue'),
        NavbarComponent: () => import('../components/Navbar/Navbar.vue'),
        TextIconComponent: () => import('../components/Icons/TextIcon.vue'),

        // Buttons
        BtnComponent: () => import('../components/Buttons/Btn.vue'),
        IconBtnComponent: () => import('../components/Buttons/IconBtn.vue'),
        MultipleBtnComponent: () => import('../components/Buttons/MultipleBtn.vue'),

        // Items
        URLComponent: () => import('../components/Items/URL.vue'),
        BadgeComponent: () => import('../components/Items/Badge.vue'),
        ContentComponent: () => import('../components/Items/Content.vue'),
        UpTimerComponent: () => import('../components/Items/UpTimer.vue'),
        GroupBadgesComponent: () => import('../components/Items/GroupBadges.vue'),
        RawHtmlComponentComponent: () => import('../components/Items/RawHtml.vue'),

        // Overviews
        CardComponent: () => ({
            component: import('../components/Overviews/Card.vue'),
            loading: SkeletonCard,
            delay: 0,
            error: ComponentError,
            timeout: 10000
        }),
        ListComponent: () => ({
            component: import('../components/Overviews/List.vue'),
            loading: SkeletonList,
            delay: 0,
            error: ComponentError,
            timeout: 10000
        }),
        PageComponent: () => ({
            component: import('../components/Overviews/Page.vue'),
            ...LazyImportConfig
        }),
        ChartComponent: () => ({
            component: import('../components/Overviews/Chart.vue'),
            ...LazyImportConfig
        }),
        TableComponent: () => ({
            component: import('../components/Overviews/Table.vue'),
            loading: SkeletonDataTable,
            delay: 0,
            error: ComponentError,
            timeout: 10000
        }),
        EmptyComponent: () => ({
            component: import('../components/Overviews/Empty.vue'),
            ...LazyImportConfig
        }),

        // Forms
        FormComponent: () => ({
            component: import('../components/Forms/Form.vue'),
            ...LazyImportConfig
        }),
        CustomFormComponent: () => ({
            component: import('../components/Forms/CustomForm.vue'),
            ...LazyImportConfig
        }),

        // Inputs
        TextInputComponent: () => import('../components/Forms/Inputs/TextInput.vue'),
        SelectInputComponent: () => import('../components/Forms/Inputs/SelectInput.vue'),
        NumberInputComponent: () => import('../components/Forms/Inputs/NumberInput.vue'),
        CustomInputComponent: () => import('../components/Forms/Inputs/CustomInput.vue'),
        CheckboxInputComponent: () => import('../components/Forms/Inputs/CheckboxInput.vue'),
        TextareaInputComponent: () => import('../components/Forms/Inputs/TextareaInput.vue'),
        ConditionInputComponent: () => import('../components/Forms/Inputs/ConditionInput.vue'),
        CodeEditorInputComponent: () => import('../components/Forms/Inputs/CodeEditorInput.vue'),
        TimePickerInputComponent: () => import('../components/Forms/Inputs/TimePickerInput.vue'),
        DatePickerInputComponent: () => import('../components/Forms/Inputs/DatePickerInput.vue'),
        RichTextareaInputComponent: () => import('../components/Forms/Inputs/RichTextareaInput.vue'),
        DatetimePickerInputComponent: () => import('../components/Forms/Inputs/DatetimePickerInput.vue'),
    }
}
