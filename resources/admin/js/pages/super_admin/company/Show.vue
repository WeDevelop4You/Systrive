<template>
    <v-row>
        <v-col cols="3">
            <DetailsCard
                v-model="data.list_details"
                :title="$vuetify.lang.t('$vuetify.word.details')"
            />
        </v-col>
        <v-col cols="9">
            <v-row>
                <v-col cols="12">
                    <user-access />
                </v-col>
                <v-col cols="12">
                    <roles />
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import Roles from "../../../layout/tables/Roles";
    import UserAccess from "../../../layout/tables/UserAccess";
    import DetailsCard from "../../../components/cards/DetailsCard";

    export default {
        name: "Show",

        components: {
            Roles,
            UserAccess,
            DetailsCard
        },

        computed: {
            details() {
                return [
                    {subheader: this.$vuetify.lang.t('$vuetify.word.company.details')},
                    {title: this.$vuetify.lang.t('$vuetify.word.id'), value: this.data.id},
                    {title: this.$vuetify.lang.t('$vuetify.word.name'), value: this.data.name},
                    {title: this.$vuetify.lang.t('$vuetify.word.email'), value: this.data.email},
                    {title: this.$vuetify.lang.t('$vuetify.word.domain'), value: this.data.domain, type: 'link'},
                    {divider: true},
                    {title: this.$vuetify.lang.t('$vuetify.word.information'), value: this.data.information},
                    {divider: true},
                ]
            },

            ...mapGetters({
                data: 'company/data'
            })
        }
    }
</script>
