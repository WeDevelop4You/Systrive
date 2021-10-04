<template>
    <v-app>
        <v-navigation-drawer app permanent clipped hide-overlay :mini-variant.sync="isMini" :color="isMini ? 'primary' : ''">

        </v-navigation-drawer>
        <v-app-bar app dense clipped-left>
            <v-row class="gap-3 pr-3" no-gutters>
                <v-app-bar-nav-icon class="mx-1" @click="isMini = !isMini"/>
                <router-link :to="{name: 'dashboard'}" class="line-height-0 align-self-center">
                    <svg-logo-line class="py-2" :style="{height: $vuetify.application.top + 'px'}"/>
                </router-link>
                <v-spacer/>
                <div class="align-self-center">
                    <v-menu transition="slide-y-transition" offset-y bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <div class="py-3" v-on="on">
                                <span v-text="$auth.user().email"/>
                                <v-icon class="ml-2" dense>fas fa-angle-down</v-icon>
                            </div>
                        </template>
                        <v-list class="pa-2" nav dense>
                            <template v-for="(item, i) in subMenuItems">
                                <template v-if="item.divider">
                                    <v-divider class="my-1" :key="i"/>
                                </template>
                                <template v-else>
                                    <v-list-item class="py-0 px-2" color="primary" dense link :to="item.link" @click="callFunction(item.action)" :key="i">
                                        <v-list-item-icon class="mr-4">
                                            <v-icon v-text="item.icon"/>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item.text"/>
                                        </v-list-item-content>
                                    </v-list-item>
                                </template>
                            </template>
                        </v-list>
                    </v-menu>
                </div>
            </v-row>
            <v-progress-linear absolute bottom indeterminate :active="$loading" color="primary"></v-progress-linear>
        </v-app-bar>
        <v-main>
            <v-container fluid>
                <router-view/>
            </v-container>
            <Popup/>
        </v-main>
    </v-app>
</template>

<script>
    import SvgLogoLine from '../components/svg/LogoLine'
    import Popup from "./Popup";

    export default {
        name: "App",

        data() {
            return {
                isMini: true,
            }
        },

        components: {
            Popup,
            SvgLogoLine,
        },

        computed: {
            subMenuItems() {
                return [
                    {icon: 'fas fa-user-circle', text: this.$vuetify.lang.t('word.account'), link: 'account'},
                    {icon: 'fas fa-cog', text: this.$vuetify.lang.t('word.settings'), link: 'setting'},
                    {divider: true},
                    {icon: 'fas fa-sign-out-alt', text: this.$vuetify.lang.t('word.logout'), action: 'logout'},
                ]
            },
        },

        mounted() {
            this.$store.dispatch('user/get')
        },

        methods: {
            callFunction($name) {
                if ($name !== undefined) {
                    this[$name]()
                }
            },

            logout() {
                this.$store.dispatch("$auth/logout")
            }
        }
    }
</script>

