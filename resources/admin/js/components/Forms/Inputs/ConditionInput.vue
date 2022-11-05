<template>
    <v-row dense>
        <l-col
            v-for="component in cols"
            :key="component.identifier"
            :value="component"
        />
    </v-row>
</template>

<script>
    import {get} from 'lodash'
    import LCol from "../../Layouts/Col.vue";
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "ConditionInput",

        extends: ComponentBase,

        components: {
            LCol
        },

        data() {
            return {
                vuexNamespace: this.value.data.vuexNamespace,
            }
        },

        computed: {
            data() {
                return this.$store.getters[this.vuexNamespace]
            },

            cols() {
                return get(this.data, this.value.data.path)
            }
        }
    }
</script>§
