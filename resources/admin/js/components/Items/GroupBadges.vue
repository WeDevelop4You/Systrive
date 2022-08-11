<template>
    <v-chip-group column>
        <badge
            v-for="(badge, index) in value.data.badges"
            :key="index"
            :value="badge"
        />
    </v-chip-group>
</template>

<script>
import badge from "./Badge.vue";
import ComponentProperties from "../../mixins/ComponentProperties";

export default {
    name: "GroupBadges",

    components: {
        badge,
    },

    mixins: [
        ComponentProperties
    ],
}
</script>
