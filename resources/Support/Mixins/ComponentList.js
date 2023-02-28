import SkeletonCard from "../Layout/Skeletons/SkeletonCard.vue";
import ComponentError from "../Components/ComponentError.vue";
import SkeletonList from "../Layout/Skeletons/SkeletonList.vue";
import LazyImportConfig from "../Helpers/LazyImportConfig";
import SkeletonDataTable from "../Layout/Skeletons/SkeletonDataTable.vue";

export default {
    components: {
        IconComponent: () => import('../Components/Misc/Icon.vue'),
        RowComponent: () => import('../Components/Layouts/Row.vue'),
        CustomComponent: () => import('../Components/Misc/Custom.vue'),
        MenuComponent: () => import('../Components/Menu/Menu.vue'),
        WrapperComponent: () => import('../Components/Layouts/Wrapper.vue'),

        // Buttons
        BtnComponent: () => import('../Components/Buttons/Btn.vue'),
        DropdownBtnComponent: () => import('../Components/Buttons/DropdownBtn.vue'),

        // Items
        URLComponent: () => import('../Components/Misc/URL.vue'),
        HintComponent: () => import('../Components/Misc/Hint.vue'),
        BadgeComponent: () => import('../Components/Misc/Badge.vue'),
        ImageComponent: () => import('../Components/Misc/Image.vue'),
        LabelComponent: () => import('../Components/Misc/Label.vue'),
        ContentComponent: () => import('../Components/Misc/Content.vue'),
        UpTimerComponent: () => import('../Components/Misc/UpTimer.vue'),
        RawHtmlComponent: () => import('../Components/Misc/RawHtml.vue'),
        DividerComponent: () => import('../Components/Misc/Divider.vue'),
        GroupBadgesComponent: () => import('../Components/Misc/GroupBadges.vue'),
        ImageCropperComponent: () => import('../Components/Misc/ImageCropper.vue'),

        // Overviews
        CardComponent: () => ({
            component: import('../Components/Overviews/Card.vue'),
            loading: SkeletonCard,
            delay: 0,
            error: ComponentError,
            timeout: 10000
        }),
        ListComponent: () => ({
            component: import('../Components/Overviews/List.vue'),
            loading: SkeletonList,
            delay: 0,
            error: ComponentError,
            timeout: 10000
        }),
        ChartComponent: () => ({
            component: import('../Components/Overviews/Chart.vue'),
            ...LazyImportConfig
        }),
        VerticalStepperComponent: () => ({
            component: import('../Components/Overviews/Steppers/VerticalStepper.vue'),
            ...LazyImportConfig
        }),

        // Pages
        PageComponent: () => ({
            component: import('../Components/Overviews/Page.vue'),
            ...LazyImportConfig
        }),
        EmptyComponent: () => ({
            component: import('../Components/Overviews/Empty.vue'),
            ...LazyImportConfig
        }),

        // Tables
        LocaleDataTableComponent: () => ({
            component: import('../Components/Overviews/Tables/LocaleDataTable.vue'),
            loading: SkeletonDataTable,
            delay: 0,
            error: ComponentError,
            timeout: 10000
        }),
        ServerDataTableComponent: () => ({
            component: import('../Components/Overviews/Tables/ServerDataTable.vue'),
            loading: SkeletonDataTable,
            delay: 0,
            error: ComponentError,
            timeout: 10000
        }),

        // Forms
        FormComponent: () => ({
            component: import('../Components/Forms/Form.vue'),
            ...LazyImportConfig
        }),
        CustomFormComponent: () => ({
            component: import('../Components/Forms/CustomForm.vue'),
            ...LazyImportConfig
        }),
    }
}
