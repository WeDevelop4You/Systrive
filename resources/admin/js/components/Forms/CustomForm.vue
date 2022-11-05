<template>
    <component
        v-if="isReady"
        :is="component.data.type || 'ComponentError'"
        v-bind="component.attributes"
        @defaultAction="$emit('defaultAction')"
    />
</template>

<script>
    import LazyImportProperties from "../../helpers/LazyImportConfig";
    import ComponentError from "../ComponentError.vue";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "CustomForm",

        extends: ComponentBase,

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
            OneTimePasswordEnableForm: () => ({
                component: import('../../layout/Forms/OneTimePasswordForm.vue'),
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
            CmsForm: () => ({
                component: import('../../layout/Forms/Company/Cms/CmsForm.vue'),
                ...LazyImportProperties
            }),
        },

        props: {
            vuexNamespace: {
                required: true,
                type: String,
            }
        },

        computed: {
            isReady() {
                return this.$store.getters[`${this.vuexNamespace}/isReady`]
            }
        }
    }
</script>
