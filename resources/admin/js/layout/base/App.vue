<template>
    <v-app>
        <v-navigation-drawer
            app
            permanent
            clipped
            hide-overlay
            :mini-variant.sync="isMini"
        >
            <v-list
                shaped
                dense
            >
                <template v-for="(item, index) in sideMenuItems">
                    <template v-if="item.subheader && $auth.can(item.can)">
                        <v-subheader
                            v-show="!isMini"
                            :key="index"
                        >
                            {{ item.subheader }}
                        </v-subheader>
                    </template>
                    <template v-else-if="item.divider && $auth.can(item.can)">
                        <v-divider
                            :key="index"
                            class="my-1"
                        />
                    </template>
                    <template v-else-if="$auth.can(item.can)">
                        <template v-if="item.type === 'expand'">
                            <v-list-group
                                :key="index"
                                color="text--primary"
                            >
                                <template #activator>
                                    <v-list-item-icon
                                        :class="[isMini ? 'ml-n2' : 'mr-2']"
                                        class="justify-center"
                                        style="min-width: 40px"
                                    >
                                        <v-icon
                                            v-text="item.icon"
                                        />
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title v-text="item.title" />
                                    </v-list-item-content>
                                </template>
                                <navigation-item
                                    v-show="!isMini"
                                    :item="item"
                                    :is-mini="isMini"
                                />
                            </v-list-group>
                        </template>
                        <template v-else>
                            <navigation-item
                                :key="index"
                                :item="item"
                                :is-mini="isMini"
                            />
                        </template>
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
                    <!--                    <router-view v-if="$store.state.user.hasPermission" />-->
                    <router-view />
                </div>
            </v-container>
            <popup />
        </v-main>
    </v-app>
</template>

<script>
    import DarkModeSwitchList from "../../components/DarkModeSwitchList";
    import SvgLogoLine from '../../components/svg/LogoLine'
    import Breadcrumb from '../../components/Breadcrumb'
    import Popup from "../popups";
    import {mapGetters} from "vuex";
    import NavigationItem from "../NavigationItem";

    export default {
        name: "App",

        components: {
            NavigationItem,
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

            responseDataKeep: {
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
                    {icon: 'fas fa-cog', text: this.$vuetify.lang.t('$vuetify.word.settings'), link: {name: 'user.setting.personal'}},
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
            await this.$store.dispatch('user/getOne')
            await this.$store.dispatch('navigation/getCompanies')
            await this.$store.dispatch('user/permissions/getDefault')
        },

        created() {
            this.$root.responseMethodChain(this.responseData)
            this.$root.responseMethodChain(this.responseDataKeep)
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

