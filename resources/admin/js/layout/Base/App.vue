<template>
    <v-app>
        <v-navigation-drawer
            app
            permanent
            clipped
            hide-overlay
            :mini-variant.sync="isMini"
        >
            <Navbar
                v-if="Object.keys(main).length !== 0"
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
    import Popup from "../../layout/Popups";
    import Breadcrumb from '../Breadcrumb'
    import SvgLogoLine from '../../svg/LogoLine'
    import Navbar from "../../components/Navbar/Navbar";

    export default {
        name: "App",

        components: {
            Popup,
            Navbar,
            Breadcrumb,
            SvgLogoLine,
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
            ...mapGetters({
                sub: 'navigation/sub',
                main: 'navigation/main',
            })
        },

        created() {
            this.$responseChain(this.responseData)
            this.$responseChain(this.responseDataKeep)

            this.$store.dispatch('navigation/sub')
        },
    }
</script>

