<template>
    <fragment>
        <v-icon
            v-if="component.data.side === 'left'"
            left
        >
            {{ component.content.type }}
        </v-icon>
        {{ component.content.text }}
        <v-icon
            v-if="component.data.side === 'right'"
            right
        >
            {{ component.content.type }}
        </v-icon>
    </fragment>
</template>

<script>
    import {Fragment} from "vue-fragment";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "TextIcon",

        components: {
            Fragment
        },

        extends: ComponentBase,
    }
</script>
