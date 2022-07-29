<template>
    <fragment>
        <v-icon
            v-if="value.data.side === 'left'"
            left
        >
            {{ value.content.type }}
        </v-icon>
        {{ value.content.text }}
        <v-icon
            v-if="value.data.side === 'right'"
            right
        >
            {{ value.content.type }}
        </v-icon>
    </fragment>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import {Fragment} from "vue-fragment";

    export default {
        name: "TextIcon",

        components: {
            Fragment
        },

        mixins: [
            ComponentProperties
        ]
    }
</script>
