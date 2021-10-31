<template>
    <v-container>
        <v-row>
            <v-col cols="3">
                <v-card
                    outlined
                    :elevation="$config.elevation"
                >
                    {{ data }}
                </v-card>
            </v-col>
            <v-col cols="9" />
        </v-row>
    </v-container>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Show",

        computed: {
            ...mapGetters({
                data: 'companies/data'
            })
        }
    }
</script>
