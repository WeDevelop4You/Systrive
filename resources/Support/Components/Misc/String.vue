<template>
    <span>{{ component.content.text }}</span>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "String",

        extends: ComponentBase
    }
</script>