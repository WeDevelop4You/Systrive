<template>
    <v-tooltip
        v-bind="value.attributes"
        :disabled="!value.content.text"
    >
        <template #activator="{on}">
            <slot :tooltip="on" />
        </template>
        {{ value.content.text }}
    </v-tooltip>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Tooltip",

        mixins: [
            ComponentProperties
        ]
    }
</script>
