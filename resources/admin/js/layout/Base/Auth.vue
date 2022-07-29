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
            <locale-dropdown
                fixed
                arrow-up
            />
        </v-main>
    </v-app>
</template>

<script>
    import Popup from "../../layout/Popups";
    import SvgMountain from '../../svg/Mountain'
    import LocaleDropdown from "../../components/Custom/LocaleDropdown";

    export default {
        name: "Auth",

        components: {
            Popup,
            SvgMountain,
            LocaleDropdown
        },

        async created() {
            this.$vuetify.theme.dark = true
        },
    }
</script>
