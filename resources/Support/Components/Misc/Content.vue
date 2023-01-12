<template>
    <p>
        {{ component.content.value }}
    </p>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Content",

        extends: ComponentBase,
    }
</script>
