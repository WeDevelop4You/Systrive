<template>
    <v-col v-bind="component.attributes">
        <component
            :is="component.data.component.componentName"
            v-bind="component.data.component.attributes"
            :value="component.data.component"
        />
    </v-col>
</template>

<script>
    import MainComponentBase from "../Base/MainComponentBase";

    export default {
        name: "Col",

        extends: MainComponentBase,
    }
</script>
