<template>
    <component
        :is="value.data.type || 'ComponentError'"
        v-bind="value.attributes"
        @defaultAction="$emit('defaultAction')"
    />
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import LazyImportProperties from "../../mixins/LazyImportProperties";
    import ComponentError from "../ComponentError";

    export default {
        name: "CustomForm",

        components: {
            ComponentError,
            PasswordForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/popup/password_form" */ '../../layout/Forms/PasswordForm'),
                ...LazyImportProperties
            }),
            TranslationForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/translation_form" */ '../../layout/Forms/TranslationForm'),
                ...LazyImportProperties
            }),
            UserProfileForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/popup/user_profile_form" */ '../../layout/Forms/UserProfileForm'),
                ...LazyImportProperties
            }),
            CompanyForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/company/company_form" */ '../../layout/Forms/Company/CompanyForm'),
                ...LazyImportProperties
            }),
            RecoveryCodeForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/popup/recovery_code_form" */ '../../layout/Forms/Popup/RecoveryCodeForm'),
                ...LazyImportProperties
            }),
            CompanyUserForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/company/company_user_form" */ '../../layout/Forms/Company/CompanyUserForm'),
                ...LazyImportProperties
            }),
            CompanyRoleForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/company/company_role_form" */ '../../layout/Forms/Company/CompanyRoleForm'),
                ...LazyImportProperties
            }),
            DomainForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/company/system/domain_form" */ '../../layout/Forms/Company/System/DomainForm'),
                ...LazyImportProperties
            }),
            CompanyCompleteForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/popup/company_complete_form" */ '../../layout/Forms/Popup/CompanyCompleteForm'),
                ...LazyImportProperties
            }),
            OneTimePasswordValidateForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/popup/one_time_password_form" */ '../../layout/Forms/Popup/OneTimePasswordForm'),
                ...LazyImportProperties
            }),
            OneTimePasswordEnableForm: () => ({
                component: import(/* webpackChunkName: "layout/forms/one_time_password_form" */ '../../layout/Forms/OneTimePasswordForm'),
                ...LazyImportProperties
            }),
        },

        mixins: [
            ComponentProperties
        ]
    }
</script>
