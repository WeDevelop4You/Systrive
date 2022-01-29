<template>
    <v-chip-group column>
        <v-chip
            v-for="(tag, i) in item.tags"
            :key="i"
            small
        >
            {{ tag }}
        </v-chip>
    </v-chip-group>
</template>

<script>
    import ActionProps from "../../../../mixins/ActionProps";

    export default {
        name: "Tags",

        mixins: [
            ActionProps
        ],
    }
</script>
