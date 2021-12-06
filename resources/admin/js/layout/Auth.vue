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
            <v-menu top offset-y>
                <template v-slot:activator="{ on, attrs, value }">
                    <v-btn
                        right
                        fixed
                        bottom
                        outlined
                        color="#ffffff"
                        v-bind="attrs"
                        v-on="on"
                    >
                        {{ $vuetify.lang.t('$vuetify.word.language') }}
                        <v-icon right>
                            {{ value ? 'fa-chevron-down' : 'fa-chevron-up' }}
                        </v-icon>
                    </v-btn>
                </template>

                <v-list dense>
                    <v-list-item
                        v-for="(item, index) in items"
                        :key="index"
                        @click="changeLocale(item)"
                    >
                        <v-list-item-action-text>{{ item }}</v-list-item-action-text>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-main>
    </v-app>
</template>

<script>
    import SvgMountain from '../components/svg/Mountain'
    import Popup from "./Popup";

    export default {
        name: "Auth",

        components: {
            Popup,
            SvgMountain,
        },

        data() {
            return {
                items: [
                    'test',
                    'dada',
                ]
            }
        },

        methods: {
            changeLocale(locale) {

            }
        }
    }
</script>
