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

        components: {
            Row,
        },

        extends: ComponentBase,

        data() {
            return {
                vuexNamespace: this.value.data.vuexNamespace,
            }
        },

        computed: {
            isReady() {
                return  this.$store.getters[`${this.vuexNamespace}/isReady`]
            }
        }
    }
</script>
