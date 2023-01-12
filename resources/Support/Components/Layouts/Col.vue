<template>
    <v-col v-bind="component.attributes">
        <component
            :is="component.data.component.componentName"
            :value="component.data.component"
        />
    </v-col>
</template>

<script>
    import MainComponentBase from "../Base/MainComponentBase";
    import InputComponentList from "../../Mixins/InputComponentList";

    export default {
        name: "Col",

        extends: MainComponentBase,

        mixins: [
            InputComponentList
        ],
    }
</script>
