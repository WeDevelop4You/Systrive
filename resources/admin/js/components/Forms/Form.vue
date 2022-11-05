<template>
    <row
        v-if="isReady"
        :value="component.data.form"
    />
</template>

<script>
    import Row from "../Layouts/Row.vue";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Form",

        extends: ComponentBase,

        components: {
            Row,
        },

        props: {
            vuexNamespace: {
                required: true,
                type: String
            },
        },

        computed: {
            isReady() {
                return this.$store.getters[`${this.vuexNamespace}/isReady`]
            }
        }
    }
</script>
