<template>
    <v-chip-group column>
        <template v-if="item.translated.length">
            <v-chip
                v-for="(locale, i) in item.translated"
                :key="i"
                small
            >
                {{ locale.toUpperCase() }}
            </v-chip>
        </template>
        <template v-else>
            <v-chip small>
                {{ $vuetify.lang.t('$vuetify.word.not_translated') }}
            </v-chip>
        </template>
    </v-chip-group>
</template>

<script>
    import ActionProps from "../../../../mixins/ActionProps";

    export default {
        name: "Translated",

        mixins: [
            ActionProps
        ],
    }
</script>
