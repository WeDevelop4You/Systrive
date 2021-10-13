<template>
    <v-chip-group column>
        <template v-if="item.translated.length">
            <v-chip small v-for="(locale, index) in item.translated" :key="index">
                {{ locale }}
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
