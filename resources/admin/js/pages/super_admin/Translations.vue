<template>
    <server-data-table
        :item-route="routes.items"
        :custom-items="customItems"
        :header-route="routes.headers"
        :vuex-namespace="vuexNamespace"
        :title="$vuetify.lang.t('$vuetify.word.translations')"
        refresh-button
        searchable
    >
        <template #toolbar.prepend>
            <v-select
                v-model="environment"
                :items="environments"
                :disabled="$loading"
                :label="$vuetify.lang.t('$vuetify.word.environment')"
                dense
                outlined
                hide-details
                style="max-width: 150px"
                class="mr-4"
                @change="changeEnvironment"
            />
        </template>
        <template #toolbar.append>
            <create-or-edit-modal
                ref="createOrEdit"
                v-model="showCreateOrEdit"
                :title="createOrEditTitle"
            >
                <v-row no-gutters>
                    <v-col cols="12">
                        <group-badges v-model="data.tags" />
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
            </create-or-edit-modal>
            <v-divider
                class="mx-4"
                inset
                vertical
            />
            <v-btn
                small
                color="primary"
                @click="publish"
            >
                {{ $vuetify.lang.t('$vuetify.word.publish') }}
            </v-btn>
        </template>
        <delete-modal
            ref="delete"
            v-model="showDelete"
            :title="deleteTitle"
            :content="deleteContent"
        />
    </server-data-table>
</template>

<script>
    import Index from "../../components/table/column/Index";
    import GroupBadges from "../../components/items/GroupBadges";
    import DeleteModal from "../../components/modals/DeleteModal";
    import Tags from "../../components/table/column/translations/Tags";
    import ServerDataTable from "../../components/table/ServerDataTable";
    import DeleteProperties from "../../mixins/DataTable/DeleteProperties";
    import Actions from "../../components/table/column/translations/Actions";
    import Locales from "../../components/table/column/translations/Locales";
    import CreateOrEditModal from "../../components/modals/CreateOrEditModal";
    import CreateOrEditProperties from "../../mixins/DataTable/CreateOrEditProperties";

    export default {
        name: "Translations",

        components: {
            GroupBadges,
            DeleteModal,
            ServerDataTable,
            CreateOrEditModal,
        },

        mixins: [
            DeleteProperties,
            CreateOrEditProperties
        ],

        data() {
            return {
                customItems: [
                    {name: 'index', component: Index},
                    {name: 'tags', component: Tags},
                    {name: 'translated', component: Locales},
                    {name: 'actions', component: Actions},
                ],

                environment: 'frontend',
                vuexNamespace: 'translations'
            }
        },

        computed: {
            routes() {
                return {
                    headers: this.$api.route('admin.translation.table.headers'),
                    items: this.$api.route('admin.translation.table.items', this.environment),
                }
            },

            environments() {
                return this.$store.getters[`${this.vuexNamespace}/environments`]
            },
        },

        created() {
            this.$store.dispatch(`${this.vuexNamespace}/getEnvironments`)
            this.$store.commit(`${this.vuexNamespace}/removeLoadAction`, 'new')

            this.$store.commit(`${this.vuexNamespace}/setStructure`, {
                id: '',
                key: '',
                group: '',
                environment: '',
                tags: [],
                sources: [],
                translations: [],
            })
        },

        methods: {
            changeEnvironment() {
                this.$nextTick(function () {
                    this.$refs.server.page = 1
                    this.$refs.server.generateParams()
                })
            },

            publish() {
                this.$store.dispatch(`${this.vuexNamespace}/publish`)
            },
        }
    }
</script>
