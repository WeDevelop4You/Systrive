<template>
    <server-data-table
        ref="server"
        :route="route"
        :headers="headers"
        :custom-items="customItems"
        :vuex-namespace="vuexNamespace"
        :title="$vuetify.lang.t('$vuetify.word.companies')"
        searchable
    >
        <template #toolbar.prepend>
            <create-or-edit-modal
                ref="createOrEdit"
                v-model="showCreateOrEdit"
                :title="createOrEditTitle"
                rerender
            >
                <template #button>
                    <default-button
                        :content="$vuetify.lang.t('$vuetify.word.create.create')"
                        @click="openCreate"
                    />
                </template>
                <f-company
                    v-model="data"
                    :errors="errors"
                    :is-editing="isEditing"
                />
            </create-or-edit-modal>
        </template>
        <delete-modal
            ref="delete"
            v-model="showDelete"
            :content="deleteContent"
            :title="deleteTitle"
        />
        <overview-modal
            v-model="showOverview"
            :title="$vuetify.lang.t('$vuetify.word.show.company')"
            rerender
        >
            <show />
        </overview-modal>
    </server-data-table>
</template>

<script>
    import Show from "./Show";
    import Status from "../../../components/table/column/Status";
    import FCompany from "../../../layout/forms/company/Company";
    import DefaultButton from "../../../components/DefaultButton";
    import DeleteModal from "../../../components/modals/DeleteModal";
    import OverviewModal from "../../../components/modals/OverviewModal";
    import Actions from "../../../components/table/column/company/Actions";
    import ServerDataTable from "../../../components/table/ServerDataTable";
    import DeleteProperties from "../../../mixins/DataTable/DeleteProperties";
    import CreateOrEditModal from "../../../components/modals/CreateOrEditModal";
    import OverviewProperties from "../../../mixins/DataTable/OverviewProperties";
    import CreateOrEditProperties from "../../../mixins/DataTable/CreateOrEditProperties";

    export default {
        name: "Index",

        mixins: [
            DeleteProperties,
            OverviewProperties,
            CreateOrEditProperties
        ],

        components: {
            Show,
            FCompany,
            DeleteModal,
            OverviewModal,
            DefaultButton,
            ServerDataTable,
            CreateOrEditModal,
        },

        data() {
            return {
                customItems: [
                    {name: 'status', component: Status},
                    {name: 'actions', component: Actions}
                ],

                vuexNamespace: "companies",
                route: this.$api.route('admin.companies')
            }
        },

        computed: {
            headers() {
                return [
                    {text: this.$vuetify.lang.t('$vuetify.word.id'), value: 'id', sortable: true, align: 'start'},
                    {text: this.$vuetify.lang.t('$vuetify.word.name'), value: 'name', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.email'), value: 'email', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.owner'), value: 'owner.full_name', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.status'), value: 'status', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.created_at'), value: 'created_at', sortable: true, divider: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: 'end'},
                ]
            },
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/addLoadAction`, {
                actionType: 'show',
                action: async ({commit, dispatch}, params) => {
                    await dispatch('company/getOne', params.id, {root: true})

                    commit('setOverview', params.id)
                }
            })

            this.$store.commit(`${this.vuexNamespace}/setStructure`,{
                name: '',
                email: '',
                domain: '',
                information: '',
                owner: {},
            })

            this.$store.dispatch('permissions/getList')
        }
    }
</script>
