<template>
    <server-data-table ref="server" :custom-items="customItems" :title="$vuetify.lang.t('$vuetify.word.translations')" :headers="headers" :route="$api.route('admin.translations.environment', environment)" vuex-namespace="translations" searchable>
        <template v-slot:toolbar.prepend>
            <v-select class="mr-4" v-model="environment" :items="environments" dense outlined :label="$vuetify.lang.t('$vuetify.word.environment')" hide-details :disabled="$loading" @change="changeEnvironment" style="max-width: 200px"></v-select>
        </template>
        <template v-slot:toolbar.append>
            <edit-dialog disable-create :form-title="$vuetify.lang.t('$vuetify.word.edit.translation')" vuex-namespace="translations" @save="save">
                <v-form v-model="valid">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-chip-group column>
                                <v-chip small v-for="(tag, index) in translationData.tags" :key="index">{{ tag }}</v-chip>
                            </v-chip-group>
                        </v-col>
                        <v-col cols="6">
                            <v-list-item two-line class="pl-0">
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-bold">{{ $vuetify.lang.t('$vuetify.word.environment') }}</v-list-item-title>
                                    <v-list-item-subtitle>{{ translationData.environment }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col cols="6">
                            <v-list-item two-line class="pr-0">
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-bold">{{ $vuetify.lang.t('$vuetify.word.group') }}</v-list-item-title>
                                    <v-list-item-subtitle>{{ translationData.group }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col cols="12">
                            <v-list-item two-line class="px-0">
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-bold">{{ $vuetify.lang.t('$vuetify.word.key') }}</v-list-item-title>
                                    <v-list-item-subtitle>{{ translationData.key }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col cols="12" v-for="(translation, index) in translationData.translations" :key="index">
                            <v-text-field v-model="translation.translation" :label="translation.locale.toUpperCase()" dense outlined></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-expansion-panels flat class="text--disabled" style="border: 1px solid;">
                                <v-expansion-panel>
                                    <v-expansion-panel-header class="px-3 py-2" style="min-height: 40px">{{ $vuetify.lang.t('$vuetify.word.translation.sources') }}</v-expansion-panel-header>
                                    <v-expansion-panel-content class="translation">
                                        <ul><li v-for="(source, index) in translationData.sources" :key="index">{{ source }}</li></ul>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-col>
                    </v-row>
                </v-form>
            </edit-dialog>
        </template>
        <template v-slot:delete>
            <delete-dialog :title="$vuetify.lang.t('$vuetify.word.delete.translation')" vuex-namespace="translations" @delete="destroy"></delete-dialog>
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
                    this.$refs.server.page = 1
                    this.$refs.server.getData()
                })
            },

            async save() {
                await this.$store.dispatch('translations/update', this.translationData)
                this.$refs.server.getData();
            },

            async destroy() {
                await this.$store.dispatch('translations/destroy')
                this.$refs.server.getData();
            }
        }
    }
</script>
