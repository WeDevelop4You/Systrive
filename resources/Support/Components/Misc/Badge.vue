<template>
    <v-chip
        v-bind="component.attributes"
        label
        small
        link
        class="cursor-default max-w-max-content"
    >
        {{ component.content.value }}
    </v-chip>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Badge",

        extends: ComponentBase
    }
</script>
