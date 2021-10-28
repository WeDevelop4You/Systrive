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
    export default {
        name: "Tags",

        props: {
            item: {
                required: true,
                type: Object
            },

            isMobile: {
                required: true,
                type: Boolean
            },

            header: {
                required: true,
                type: Object
            },

            index: {
                required: true,
                type: Number
            }
        }
    }
</script>
