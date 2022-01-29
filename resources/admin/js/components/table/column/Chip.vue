<template>
    <v-chip
        :color="item.status.color"
        small
    >
        {{ item.status.text }}
    </v-chip>
</template>

<script>
    import actionProps from "../../../mixins/ActionProps";

    export default {
        name: "Chip",

        mixins: [
            actionProps
        ]
    }
</script>
