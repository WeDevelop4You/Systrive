<template>
    <v-app>
        <v-navigation-drawer
            app
            permanent
            clipped
            hide-overlay
            :mini-variant.sync="isMini"
        >
            <v-list shaped>
                <template v-for="(item, index) in sideMenuItems">
                    <template v-if="item.subheader">
                        <v-subheader
                            v-show="!isMini"
                            :key="index"
                        >
                            {{ item.subheader }}
                        </v-subheader>
                    </template>
                    <template v-else-if="item.divider">
                        <v-divider
                            :key="index"
                            class="my-1"
                        />
                    </template>
                    <template v-else>
                        <v-list-item-group
                            :key="index"
                            color="primary"
                        >
                            <v-list-item
                                v-for="(navigation, key) in item.navigationItems"
                                :key="index + '_' + key"
                                :class="{'pl-2': isMini}"
                                :to="navigation.route"
                                dense
                            >
                                <template v-if="navigation.avatar">
                                    <v-list-item-avatar
                                        :class="{'mr-2': !isMini}"
                                        class="my-1"
                                        max-width="28"
                                        max-height="28"
                                    >
                                        <v-img
                                            max-width="28"
                                            max-height="28"
                                            :src="navigation.avatar"
                                        />
                                    </v-list-item-avatar>
                                </template>
                                <template v-else>
                                    <v-list-item-icon
                                        :class="{'mr-2': !isMini}"
                                        class="justify-center"
                                        style="min-width: 40px"
                                    >
                                        <v-icon
                                            dense
                                            v-text="navigation.icon"
                                        />
                                    </v-list-item-icon>
                                </template>
                                <v-list-item-content>
                                    <v-list-item-title v-html="navigation.name" />
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </template>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar
            app
            dense
            clipped-left
        >
            <v-row
                class="gap-3 pr-3"
                no-gutters
            >
                <v-app-bar-nav-icon
                    class="mx-1"
                    @click="isMini = !isMini"
                />
                <router-link
                    :to="{name: 'dashboard'}"
                    class="line-height-0 align-self-center"
                >
                    <svg-logo-line
                        class="py-2"
                        :style="{height: $vuetify.application.top + 'px'}"
                    />
                </router-link>
                <v-spacer />
                <div class="align-self-center cursor-pointer">
                    <v-menu
                        transition="slide-y-transition"
                        offset-y
                        bottom
                        :close-on-content-click="false"
                    >
                        <template #activator="{ on }">
                            <div
                                class="py-3"
                                v-on="on"
                            >
                                <span v-text="$auth.user().email" />
                                <v-icon
                                    class="ml-2"
                                    dense
                                >
                                    fas fa-angle-down
                                </v-icon>
                            </div>
                        </template>
                        <v-list
                            class="pa-2"
                            nav
                            dense
                        >
                            <template v-for="(item, i) in subMenuItems">
                                <template v-if="item.divider">
                                    <v-divider
                                        :key="i"
                                        class="my-1"
                                    />
                                </template>
                                <template v-else-if="item.component">
                                    <component
                                        :is="item.component"
                                        :key="i"
                                        :index="i"
                                    />
                                </template>
                                <template v-else>
                                    <v-list-item
                                        :key="i"
                                        class="py-0 px-2"
                                        color="primary"
                                        dense
                                        link
                                        :to="item.link"
                                        @click="callFunction(item.action)"
                                    >
                                        <v-list-item-icon class="mr-4">
                                            <v-icon
                                                dense
                                                v-text="item.icon"
                                            />
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item.text" />
                                        </v-list-item-content>
                                    </v-list-item>
                                </template>
                            </template>
                        </v-list>
                    </v-menu>
                </div>
            </v-row>
            <v-progress-linear
                absolute
                bottom
                indeterminate
                :active="$loading"
                color="primary"
            />
        </v-app-bar>
        <v-main>
            <v-container fluid>
                <breadcrumb />
                <div class="px-6">
                    <router-view />
                </div>
            </v-container>
            <popup />
        </v-main>
    </v-app>
</template>

<script>
    import DarkModeSwitchList from "../components/DarkModeSwitchList";
    import SvgLogoLine from '../components/svg/LogoLine'
    import Breadcrumb from '../components/Breadcrumb'
    import Popup from "./Popup";
    import {mapGetters} from "vuex";

    export default {
        name: "App",

        components: {
            Popup,
            Breadcrumb,
            SvgLogoLine,
            DarkModeSwitchList
        },

        props: {
            responseData: {
                required: true,
                type: Object
            },

            responseDataModal: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                isMini: true,
            }
        },

        computed: {
            subMenuItems() {
                return [
                    {icon: 'fas fa-user-circle', text: this.$vuetify.lang.t('$vuetify.word.account.account'), link: {name: 'account'}},
                    {icon: 'fas fa-cog', text: this.$vuetify.lang.t('$vuetify.word.settings'), link: {name: 'settings'}},
                    {divider: true},
                    {component: 'DarkModeSwitchList'},
                    {divider: true},
                    {icon: 'fas fa-sign-out-alt', text: this.$vuetify.lang.t('$vuetify.word.logout'), action: 'logout'},
                ]
            },

            ...mapGetters({
                sideMenuItems: 'navigation/menuItems',
            })
        },

        watch:{
            $route (to, from) {
                this.$root.lastRoute = from.fullPath
            }
        },

        async beforeCreate() {
            await this.$store.dispatch('user/get')
            await this.$store.dispatch('navigation/getCompanies', true)
        },

        created() {
            this.$root.responseActions(this.responseData)
            this.$root.responseActions(this.responseDataModal)
        },

        methods: {
            callFunction($name) {
                if ($name !== undefined) {
                    this[$name]()
                }
            },

            logout() {
                this.$store.dispatch("user/logout")
            },
        }
    }
</script>

