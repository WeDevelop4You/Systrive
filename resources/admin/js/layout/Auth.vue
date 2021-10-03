<template>
    <v-app class="pattern-background">
        <v-main>
            <svg-mountain class="mountain"/>
            <v-container fluid class="fill-height">
                <v-row>
                    <v-col cols="12" md="4" lg="3" offset-md="2">
                        <v-card class="mx-auto" rounded="lg" outlined :elevation="$config.elevation" width="400px">
                            <slot></slot>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    import SvgMountain from '../components/svg/Mountain'

    export default {
        name: "Auth",

        components: {
            SvgMountain,
        },
    }
</script>
