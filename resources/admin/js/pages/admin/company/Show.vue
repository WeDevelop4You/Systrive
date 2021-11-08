<template>
    <v-row>
        <v-col cols="3">
            <v-card flat>
                {{ data }}
            </v-card>
        </v-col>
        <v-col cols="9">
            <user-access />
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import UserAccess from "../../../layout/tables/UserAccess";

    export default {
        name: "Show",

        components: {
            UserAccess
        },

        computed: {
            ...mapGetters({
                data: 'company/data'
            })
        },
    }
</script>
