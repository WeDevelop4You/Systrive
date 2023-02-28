<template>
    <v-menu
        :top="arrowUp"
        offset-y
    >
        <template #activator="{ on, attrs, value }">
            <v-btn
                :text="fixed"
                :right="fixed"
                :fixed="fixed"
                :bottom="fixed"
                :outlined="!fixed"
                color="#ffffff"
                v-bind="attrs"
                v-on="on"
            >
                <v-icon
                    v-if="fixed"
                    left
                >
                    fa-globe
                </v-icon>
                {{ locale.name }}
                <v-icon right>
                    {{ (arrowUp ? value : !value) ? 'fa-angle-down' : 'fa-angle-up' }}
                </v-icon>
            </v-btn>
        </template>

        <v-list>
            <v-list-item
                v-for="(item, index) in items"
                :key="index"
                @click="changeLocale(item)"
            >
                {{ item.name }}
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "LocaleDropdown",

    props: {
        fixed: {
            type: Boolean,
            default: false,
        },

        arrowUp: {
            type: Boolean,
            default: false,
        }
    },

    computed: {
        ...mapGetters({
            locale: 'locale/data',
            items: 'locales/items'
        })
    },

    methods: {
        async changeLocale(value) {
            await this.$store.dispatch('locales/change', value)
        }
    }
}
</script>
