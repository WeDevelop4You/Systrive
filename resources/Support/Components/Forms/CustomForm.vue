<template>
    <component
        :is="component.data.type || 'ComponentError'"
        v-if="isReady"
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

        components: {
            ComponentError,
            DomainForm: () => ({
                component: import('../../../App/Company/Layout/Forms/System/DomainForm.vue'),
                ...LazyImportProperties
            }),
        },

        extends: ComponentBase,

        data() {
            return {
                vuexNamespace: this.value.data.vuexNamespace,
            }
        },

        computed: {
            isReady() {
                return this.$store.getters[`${this.vuexNamespace}/isReady`]
            }
        }
    }
</script>
