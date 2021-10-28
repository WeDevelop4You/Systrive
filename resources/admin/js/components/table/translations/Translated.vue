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
    export default {
        name: "Translated",

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
