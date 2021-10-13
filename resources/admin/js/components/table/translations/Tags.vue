<template>
    <v-chip-group column>
        <v-chip small v-for="(tag, index) in item.tags" :key="index">
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
