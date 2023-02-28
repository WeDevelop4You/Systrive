<template>
    <v-app>
        <v-app-bar
            app
            dense
            clipped-left
        >
            <v-row
                class="gap-3 px-3"
                no-gutters
            >
                <div class="line-height-0 align-self-center">
                    <svg-logo-line
                        class="py-2"
                        :style="{height: $vuetify.application.top + 'px'}"
                    />
                </div>
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
    import Popup from "./PopupLayout.vue";
    import SvgLogoLine from '../Components/Svg/Logo.vue'
    import Navbar from "../Components/Menu/Menu.vue";
    import Breadcrumb from './BreadcrumbLayout.vue'

    export default {
        name: "Minimal",

        components: {
            Popup,
            Navbar,
            Breadcrumb,
            SvgLogoLine,
        },

        computed: {
            ...mapGetters({
                sub: 'navigation/sub',
            })
        },
    }
</script>

