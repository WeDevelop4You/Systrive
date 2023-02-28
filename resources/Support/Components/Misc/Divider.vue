<template>
    <v-divider v-bind="component.attributes" />
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Divider",

        extends: ComponentBase,
    }
</script>
