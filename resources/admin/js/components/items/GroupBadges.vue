<template>
    <v-chip-group column>
        <badge
            v-for="(item, index) in items"
            :key="index"
            :value="item"
        />
    </v-chip-group>
</template>

<script>
import badge from "./Badge";

export default {
    name: "GroupBadges",

    components: {
        badge,
    },

    props: {
        value: {
            required: true,
            type: Array
        },

        noContent: {
            type: String,
            default: undefined
        }
    },

    computed: {
        items() {
            return this.value.length ? this.value : [this.noContent ?? this.$vuetify.lang.t('$vuetify.word.no_content')]
        }
    }
}
</script>
