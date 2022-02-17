<template>
    <v-app class="pattern-background">
        <v-main>
            <svg-mountain class="mountain" />
            <v-container
                fluid
                class="fill-height"
            >
                <v-row>
                    <v-col
                        cols="12"
                        md="4"
                        lg="3"
                        offset-md="2"
                    >
                        <slot />
                    </v-col>
                </v-row>
            </v-container>
            <popup />
            <v-menu
                top
                offset-y
            >
                <template #activator="{ on, attrs, value }">
                    <v-btn
                        right
                        fixed
                        bottom
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
                            {{ value ? 'fa-chevron-down' : 'fa-chevron-up' }}
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
        </v-main>
    </v-app>
</template>

<script>
    import Popup from "../popups"
    import {mapGetters} from "vuex";
    import SvgMountain from '../../components/svg/Mountain'

    export default {
        name: "Auth",

        components: {
            Popup,
            SvgMountain,
        },

        computed: {
            getFlag() {
                return Object.keys(this.items).find(flag => this.items[flag] === this.locale) || 'us'
            },

            ...mapGetters({
                items: 'locale/items',
                locale: 'locale/locale',
            })
        },

        methods: {
            changeLocale(locale) {
                this.$store.dispatch('locale/setLocale', locale)
            }
        }
    }
</script>
