<template>
    <v-app>
        <v-navigation-drawer
            app
            permanent
            clipped
            hide-overlay
            :mini-variant.sync="isMini"
        >
            <template v-if="!isLoad">
                <skeleton-navbar :is-hidden="isMini"/>
            </template>
            <Navbar
                v-else
                :value="main"
                :is-hidden="isMini"
            />
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
                        :nudge-left="18"
                        :close-on-content-click="false"
                        transition="slide-y-transition"
                        offset-y
                        bottom
                    >
                        <template #activator="{on}">
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
                        <navbar
                            v-if="Object.keys(sub).length !== 0"
                            :value="sub"
                        />
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
                    <router-view :key="$route.name" />
                </div>
            </v-container>
            <popup />
        </v-main>
    </v-app>
</template>

<script>
    import {mapGetters} from "vuex";
    import Popup from "../../layout/Popups.vue";
    import Breadcrumb from '../Breadcrumb.vue'
    import SvgLogoLine from '../../svg/Logo.vue'
    import Navbar from "../../components/Navbar/Navbar.vue";
    import SkeletonNavbar from "../../layout/Skeletons/SkeletonNavbar.vue";

    export default {
        name: "App",

        components: {
            Popup,
            Navbar,
            Breadcrumb,
            SvgLogoLine,
            SkeletonNavbar
        },

        props: {
            response: {
                required: true,
                type: Array
            },
        },

        data() {
            return {
                isMini: true,
            }
        },

        computed: {
            isLoad() {
                return Object.keys(this.main).length !== 0
            },

            ...mapGetters({
                sub: 'navigation/sub',
                main: 'navigation/main',
            })
        },

        created() {
            this.response.forEach((data) => {
                this.$responseChain(data)
            })

            this.$store.dispatch('navigation/sub')
        },
    }
</script>

