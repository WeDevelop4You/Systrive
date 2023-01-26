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
                        cols="auto"
                        offset-md="2"
                    >
                        <view-layer :value="overview" />
                    </v-col>
                </v-row>
            </v-container>
            <popup />
            <locale-dropdown
                fixed
                arrow-up
            />
        </v-main>
    </v-app>
</template>

<script>
    import ViewBase from "../../../Support/Views/ViewBase";
    import Popup from "../../../Support/Layout/PopupLayout.vue";
    import SvgMountain from "../../../Support/Components/Svg/Mountain.vue";
    import LocaleDropdown from "../../../Support/Components/Misc/Custom/LocaleDropdown.vue";

    export default {
        name: "Auth",

        components: {
            Popup,
            SvgMountain,
            LocaleDropdown
        },

        extends: ViewBase,

        props: {
            route: {
                required: true,
                type: Function
            }
        },

        methods: {
            getRoute() {
                return this.route(this)
            },
        }
    }
</script>
