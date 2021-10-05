<template>
    <v-app>
        <v-navigation-drawer app permanent clipped hide-overlay :mini-variant.sync="isMini" :color="isMini ? 'primary' : ''">
            <v-list shaped>
                <template v-for="(item, index) in sideMenuItems">
                    <template v-if="item.subheader">
                        <v-subheader v-show="!isMini" :key="index">{{ item.subheader }}</v-subheader>
                    </template>
                    <template v-else-if="item.divider">
                        <v-divider class="my-1" :key="index"/>
                    </template>
                    <template v-else>
                        <v-list-item-group color="primary">
                            <v-list-item :class="{'pl-2': isMini}" :to="navigation.route" v-for="(navigation, i) in item.navigationItems" :key="i">
                                <v-list-item-avatar>
                                    <v-img :src="navigation.avatar"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title v-html="navigation.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </template>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar app dense clipped-left>
            <v-row class="gap-3 pr-3" no-gutters>
                <v-app-bar-nav-icon class="mx-1" @click="isMini = !isMini"/>
                <router-link :to="{name: 'dashboard'}" class="line-height-0 align-self-center">
                    <svg-logo-line class="py-2" :style="{height: $vuetify.application.top + 'px'}"/>
                </router-link>
                <v-spacer/>
                <div class="align-self-center cursor-pointer">
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
                <breadcrumb/>
                <router-view/>
            </v-container>
            <popup/>
        </v-main>
    </v-app>
</template>

<script>
    import SvgLogoLine from '../components/svg/LogoLine'
    import Breadcrumb from '../components/Breadcrumb'
    import Popup from "./Popup";

    export default {
        name: "App",

        data() {
            return {
                isMini: true,
                companies: [
                    {
                        id:	1,
                        name: "WeDevelop4You",
                        avatar: "https://avatar.oxro.io/avatar.svg?name=WeDevelop4You&rounded=250&caps=1",
                        route: {
                            name: 'company',
                            params: { company: "WeDevelop4You" }
                        }
                    }
                ]
            }
        },

        components: {
            Popup,
            Breadcrumb,
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

            sideMenuItems() {
                return [
                    {subheader: this.$vuetify.lang.t('$vuetify.word.companies')},
                    {navigationItems: this.companies},
                    {divider: true},
                    {subheader: this.$vuetify.lang.t('$vuetify.word.admin')},
                ]
            }
        },

        mounted() {
            this.$store.dispatch('user/get')

            this.$api.call({
                url: '/api/companies',
                method: "GET"
            })
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

