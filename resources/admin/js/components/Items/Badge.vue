<template>
    <v-chip
        v-bind="value.attributes"
        label
        small
        link
    >
        {{ value.content.value }}
    </v-chip>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Badge",

        mixins: [
            ComponentProperties
        ]
    }
</script>
