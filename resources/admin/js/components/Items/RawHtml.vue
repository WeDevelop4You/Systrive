<template>
    <div v-html="component.content.html"/>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "RawHtml",

        extends: ComponentBase,
    }
</script>
