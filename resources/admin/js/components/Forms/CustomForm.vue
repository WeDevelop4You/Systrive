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
    import ComponentError from "../ComponentError.vue";

    export default {
        name: "CustomForm",

        components: {
            ComponentError,
            PasswordForm: () => ({
                component: import('../../layout/Forms/PasswordForm.vue'),
                ...LazyImportProperties
            }),
            TranslationForm: () => ({
                component: import('../../layout/Forms/TranslationForm.vue'),
                ...LazyImportProperties
            }),
            UserProfileForm: () => ({
                component: import('../../layout/Forms/UserProfileForm.vue'),
                ...LazyImportProperties
            }),
            CompanyForm: () => ({
                component: import('../../layout/Forms/Company/CompanyForm.vue'),
                ...LazyImportProperties
            }),
            RecoveryCodeForm: () => ({
                component: import('../../layout/Forms/Popup/RecoveryCodeForm.vue'),
                ...LazyImportProperties
            }),
            CompanyUserForm: () => ({
                component: import('../../layout/Forms/Company/CompanyUserForm.vue'),
                ...LazyImportProperties
            }),
            CompanyRoleForm: () => ({
                component: import('../../layout/Forms/Company/CompanyRoleForm.vue'),
                ...LazyImportProperties
            }),
            DomainForm: () => ({
                component: import('../../layout/Forms/Company/System/DomainForm.vue'),
                ...LazyImportProperties
            }),
            CompanyCompleteForm: () => ({
                component: import('../../layout/Forms/Popup/CompanyCompleteForm.vue'),
                ...LazyImportProperties
            }),
            OneTimePasswordValidateForm: () => ({
                component: import('../../layout/Forms/Popup/OneTimePasswordForm.vue'),
                ...LazyImportProperties
            }),
            OneTimePasswordEnableForm: () => ({
                component: import('../../layout/Forms/OneTimePasswordForm.vue'),
                ...LazyImportProperties
            }),
        },

        mixins: [
            ComponentProperties
        ]
    }
</script>
