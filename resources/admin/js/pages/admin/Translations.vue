<template>
    <server-data-table ref="server" :custom-items="customItems" :title="$vuetify.lang.t('$vuetify.word.translations')" :headers="headers" :route="$api.route('admin.translations.environment', environment)" vuex-namespace="translations" searchable>
        <template v-slot:toolbar.prepend>
            <v-select class="mr-4" v-model="environment" :items="environments" dense outlined :label="$vuetify.lang.t('$vuetify.word.environment')" hide-details :disabled="$loading" @change="changeEnvironment" style="max-width: 200px"></v-select>
        </template>
        <template v-slot:toolbar.append>
            <edit-dialog disable-create :form-title="$vuetify.lang.t('$vuetify.word.translation.edit')" vuex-namespace="translations">
                <v-form v-model="valid">
                    <v-row no-gutters>
                        <v-col cols="12">

                        </v-col>
                        <v-col cols="12" v-for="translation in translationData.translations" :key="translation.id">
                            <v-text-field v-model="translation.translation" :label="translation.locale.toUpperCase()" dense outlined></v-text-field>
                        </v-col>
                    </v-row>
                </v-form>
            </edit-dialog>
        </template>
        <template v-slot:delete>
            <delete-dialog :title="$vuetify.lang.t('$vuetify.word.translation.delete')" vuex-namespace="translations" @delete="destroy"></delete-dialog>
        </template>
    </server-data-table>
</template>

<script>
    import Tags from "../../components/table/translations/Tags";
    import DeleteDialog from "../../components/table/DeleteDialog";
    import ServerDataTable from "../../components/ServerDataTable";
    import Actions from "../../components/table/translations/Actions";
    import Translated from "../../components/table/translations/Translated";
    import EditDialog from "../../components/table/EditDialog";
    import {mapGetters} from "vuex";

    export default {
        name: "Translations",

        components: {
            EditDialog,
            DeleteDialog,
            ServerDataTable
        },

        data() {
            return {
                valid: true,

                customItems: [
                    {name: 'tags', component: Tags},
                    {name: 'translated', component: Translated},
                    {name: 'actions', component: Actions},
                ],

                environment: 'frontend'
            }
        },

        computed: {
            headers() {
                return [
                    {text: 'Key', value: 'key', sortable: true, align: 'start'},
                    {text: 'Group', value: 'group', sortable: true},
                    {text: 'Tags', value: 'tags', sortable: true},
                    {text: 'Translated', value: 'translated', sortable: true},
                    {text: 'Actions', value: 'actions', sortable: false, align: 'end'},
                ]
            },

            ...mapGetters({
                translationData: 'translations/selected',
                environments: 'translations/environments',
            })
        },

        created() {
            this.$store.dispatch('translations/getEnvironments')
        },

        methods: {
            changeEnvironment() {
                this.$nextTick(function () {
                    this.$refs.server.getData()
                })
            },

            destroy() {

            }
        }
    }
</script>
