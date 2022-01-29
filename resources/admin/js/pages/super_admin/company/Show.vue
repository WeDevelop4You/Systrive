<template>
    <v-row>
        <v-col cols="3">
            <v-card flat>
                <v-list
                    dense
                    class="dialog-divide-color"
                >
                    <template v-for="(item, index) in details">
                        <template v-if="item.divider">
                            <v-divider :key="index" />
                        </template>
                        <template v-else-if="item.subheader">
                            <v-subheader
                                :key="index"
                                class="title"
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
                                    <template v-if="item.type === 'link'">
                                        <Url :href="item.value" />
                                    </template>
                                    <template v-else>
                                        <v-list-item-subtitle v-text="item.value || $vuetify.lang.t('$vuetify.word.no_content')" />
                                    </template>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                    </template>
                </v-list>
            </v-card>
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
    import Url from "../../../components/Url";
    import Roles from "../../../layout/tables/Roles";
    import UserAccess from "../../../layout/tables/UserAccess";

    export default {
        name: "Show",

        components: {
            Url,
            Roles,
            UserAccess
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
