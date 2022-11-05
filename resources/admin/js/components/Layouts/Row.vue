<template>
    <v-row
        v-bind="component.attributes"
        :class="component.data.classes"
    >
        <l-col
            v-for="component in component.data.cols"
            :key="component.identifier"
            :value="component"
        />
    </v-row>
</template>

<script>
    import LCol from "./Col.vue";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Row",

        components: {
            LCol,
        },

        extends: ComponentBase,
    }
</script>
