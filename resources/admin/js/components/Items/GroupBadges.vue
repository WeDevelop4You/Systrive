<template>
    <v-chip-group column>
        <badge
            v-for="(badge, index) in component.data.badges"
            :key="index"
            :value="badge"
        />
    </v-chip-group>
</template>

<script>
import badge from "./Badge.vue";
import ComponentBase from "../Base/ComponentBase";

export default {
    name: "GroupBadges",

    extends: ComponentBase,

    components: {
        badge,
    },
}
</script>
