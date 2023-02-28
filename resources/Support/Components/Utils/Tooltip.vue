<template>
    <v-tooltip
        v-bind="component.attributes"
        :disabled="!component.content.text"
    >
        <template #activator="{on}">
            <slot :on="on" />
        </template>
        {{ component.content.text }}
    </v-tooltip>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Tooltip",

        extends: ComponentBase,
    }
</script>
