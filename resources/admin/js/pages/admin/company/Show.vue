<template>
    <v-row>
        <v-col cols="3">
            <v-card flat>
                <v-list dense>
                    <template v-for="(item, index) in details">
                        <template v-if="item.divider">
                            <v-divider :key="index" />
                        </template>
                        <template v-else-if="item.subheader">
                            <v-subheader
                                :key="index"
                                v-text="item.subheader"
                            />
                        </template>
                        <template v-else>
                            <v-list-item
                                :key="index"
                                dense
                            >
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title" />
                                    <v-list-item-subtitle v-text="item.value || $vuetify.lang.t('$vuetify.word.no_content')" />
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                    </template>
                </v-list>
            </v-card>
        </v-col>
        <v-col cols="9">
            <user-access />
        </v-col>
        <v-col cols="9" />
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
            details() {
                return [
                    {subheader: this.$vuetify.lang.t('$vuetify.word.company.details')},
                    {title: this.$vuetify.lang.t('$vuetify.word.id'), value: this.data.id},
                    {title: this.$vuetify.lang.t('$vuetify.word.name'), value: this.data.name},
                    {title: this.$vuetify.lang.t('$vuetify.word.email'), value: this.data.email},
                    {title: this.$vuetify.lang.t('$vuetify.word.domain'), value: this.data.domain},
                    {divider: true},
                    {title: this.$vuetify.lang.t('$vuetify.word.information'), value: this.data.information},
                    {divider: true},
                ]
            },

            ...mapGetters({
                data: 'company/data'
            })
        },
    }
</script>
