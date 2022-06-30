<template>
    <v-menu
        :top="arrowUp"
        offset-y
    >
        <template #activator="{ on, attrs, value }">
            <v-btn
                :right="fixed"
                :fixed="fixed"
                :bottom="fixed"
                outlined
                color="#ffffff"
                v-bind="attrs"
                v-on="on"
            >
                <gb-flag
                    class="mx-auto rounded"
                    :code="getFlag"
                    size="mini"
                />
                <v-icon right>
                    {{ (arrowUp ? value : !value) ? 'fa-chevron-down' : 'fa-chevron-up' }}
                </v-icon>
            </v-btn>
        </template>

        <v-list dense>
            <v-list-item
                v-for="(item, index) in items"
                :key="index"
                style="min-height: 28px"
                @click="changeLocale(item)"
            >
                <gb-flag
                    class="mx-auto rounded"
                    :code="index"
                    size="mini"
                />
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
        getFlag() {
            return Object.keys(this.items).find(flag => this.items[flag] === this.locale) || 'us'
        },

        ...mapGetters({
            items: 'locale/items',
            locale: 'locale/locale'
        })
    },

    methods: {
        async changeLocale(value) {
            await this.$store.dispatch('locale/setLocale', value)

            if (this.$route.meta.isAuthenticatedPage) {
                this.$store.dispatch('navigation/sub').then()
                this.$store.dispatch('navigation/main').then()
                this.$store.dispatch('user/auth/settings/refresh', 'personal').then()
                this.$store.dispatch(
                    'user/auth/settings/navigation/component',
                    this.$api.route('account.settings.navigation')
                ).then()
            }
        }
    }
}
</script>
