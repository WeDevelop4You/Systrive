<template>
    <v-row
        v-bind="value.attributes"
        :class="value.data.classes"
    >
        <l-col
            v-for="component in value.data.cols"
            :key="component.identifier"
            :value="component"
        />
    </v-row>
</template>

<script>
    import LCol from "./Col";
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Row",

        components: {
            LCol,
        },

        mixins: [
            ComponentProperties,
        ]
    }
</script>
