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
    import {get as _get} from 'lodash'
    import LCol from "../../Layouts/Col.vue";
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "ConditionInput",

        components: {
            LCol
        },

        extends: ComponentBase,

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
                return _get(this.data, this.value.data.path)
            }
        }
    }
</script>§
