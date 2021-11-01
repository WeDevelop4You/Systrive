<template>
    <server-data-table
        ref="server"
        :custom-items="customItems"
        :title="$vuetify.lang.t('$vuetify.word.translations')"
        :headers="headers"
        :route="$api.route('admin.translations.environment', environment)"
        vuex-namespace="translations"
        add-refresh-button
        searchable
    >
        <template #toolbar.prepend>
            <v-select
                v-model="environment"
                class="mr-4"
                :items="environments"
                dense
                outlined
                :label="$vuetify.lang.t('$vuetify.word.environment')"
                hide-details
                :disabled="$loading"
                style="max-width: 150px"
                @change="changeEnvironment"
            />
        </template>
        <template #toolbar.append>
            <v-btn
                color="primary"
                @click="publish"
            >
                {{ $vuetify.lang.t('$vuetify.word.publish') }}
            </v-btn>
            <edit-dialog
                disable-create
                :form-title="$vuetify.lang.t('$vuetify.word.edit.translation')"
                vuex-namespace="translations"
                @save="save"
            >
                <v-form v-model="valid">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-chip-group column>
                                <v-chip
                                    v-for="(tag, index) in data.tags"
                                    :key="index"
                                    small
                                >
                                    {{ tag }}
                                </v-chip>
                            </v-chip-group>
                        </v-col>
                        <v-col cols="6">
                            <v-list-item
                                two-line
                                class="pl-0"
                            >
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-bold">
                                        {{ $vuetify.lang.t('$vuetify.word.environment') }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle v-text="data.environment" />
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col cols="6">
                            <v-list-item
                                two-line
                                class="pr-0"
                            >
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-bold">
                                        {{ $vuetify.lang.t('$vuetify.word.group') }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle v-text="data.group" />
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col cols="12">
                            <v-list-item
                                two-line
                                class="px-0"
                            >
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-bold">
                                        {{ $vuetify.lang.t('$vuetify.word.key') }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle v-text="data.key" />
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col
                            v-for="(translation, index) in data.translations"
                            :key="index"
                            cols="12"
                        >
                            <v-text-field
                                v-model="translation.translation"
                                :label="translation.locale.toUpperCase()"
                                dense
                                outlined
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-expansion-panels
                                flat
                                class="text--disabled"
                                style="border: 1px solid;"
                            >
                                <v-expansion-panel>
                                    <v-expansion-panel-header
                                        class="px-3 py-2"
                                        style="min-height: 40px"
                                    >
                                        {{ $vuetify.lang.t('$vuetify.word.translation.sources') }}
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content class="translation">
                                        <ul>
                                            <li
                                                v-for="(source, index) in data.sources"
                                                :key="index"
                                            >
                                                {{ source }}
                                            </li>
                                        </ul>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-col>
                    </v-row>
                </v-form>
            </edit-dialog>
        </template>
        <delete-dialog
            :title="$vuetify.lang.t('$vuetify.word.delete.translation')"
            vuex-namespace="translations"
            @delete="destroy"
        />
    </server-data-table>
</template>

<script>
    import Tags from "../../components/table/translations/Tags";
    import DeleteDialog from "../../components/table/DeleteDialog";
    import ServerDataTable from "../../components/ServerDataTable";
    import Actions from "../../components/table/translations/Actions";
    import Translated from "../../components/table/translations/Translated";
    import EditDialog from "../../components/table/CreateOrEditDialog";
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
                    {text: this.$vuetify.lang.t('$vuetify.word.key'), value: 'key', sortable: true, align: 'start'},
                    {text: this.$vuetify.lang.t('$vuetify.word.group'), value: 'group', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.tags'), value: 'tags', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.translated'), value: 'translated', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: 'end'},
                ]
            },

            ...mapGetters({
                data: 'translations/data',
                environments: 'translations/environments',
            })
        },

        beforeCreate() {
            this.$store.commit('translations/changeAllowedLoadActionState', {actionName: 'new', allowed: false})

            this.$store.commit('translations/setStructure', {
                id: '',
                key: '',
                group: '',
                environment: '',
                tags: [],
                sources: [],
                translations: [],
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

            publish() {
                this.$store.dispatch('translations/publish')
            },

            async save() {
                await this.$store.dispatch('translations/update', this.data)
                this.$refs.server.getData();
            },

            async destroy() {
                await this.$store.dispatch('translations/destroy')
                this.$refs.server.getData();
            }
        }
    }
</script>
