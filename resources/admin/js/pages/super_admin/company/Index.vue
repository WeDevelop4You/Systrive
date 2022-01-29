<template>
    <server-data-table
        ref="server"
        :custom-items="customItems"
        :title="$vuetify.lang.t('$vuetify.word.companies')"
        :headers="headers"
        :route="$api.route('admin.companies')"
        vuex-namespace="companies"
        searchable
    >
        <template #toolbar.prepend>
            <create-or-edit-dialog
                :form-title="formTitle"
                :button-title="$vuetify.lang.t('$vuetify.word.create.company')"
                rerender
                vuex-namespace="companies"
                @save="save"
            >
                <f-company
                    v-model="data"
                    :is-editing="isEditing"
                    :errors="errors"
                />
            </create-or-edit-dialog>
        </template>
        <delete-dialog
            :title="$vuetify.lang.t('$vuetify.word.delete.company')"
            vuex-namespace="companies"
            @delete="destroy"
        />
        <show-dialog
            :title="$vuetify.lang.t('$vuetify.word.show.company')"
            vuex-namespace="companies"
            rerender
        >
            <show />
        </show-dialog>
    </server-data-table>
</template>

<script>
    import Show from "./Show";
    import Chip from "../../../components/table/column/Chip";
    import FCompany from "../../../layout/forms/company/Company";
    import ShowDialog from "../../../components/table/ShowDialog";
    import Actions from "../../../components/table/column/company/Actions";
    import DeleteDialog from "../../../components/table/DeleteDialog";
    import ServerDataTable from "../../../components/table/ServerDataTable";
    import CreateOrEditDialog from "../../../components/table/CreateOrEditDialog";

    export default {
        name: "Index",

        components: {
            ShowDialog,
            Show,
            FCompany,
            DeleteDialog,
            ServerDataTable,
            CreateOrEditDialog,
        },

        data() {
            return {
                customItems: [
                    {name: 'status', component: Chip},
                    {name: 'actions', component: Actions}
                ],

                vuexNamespace: "companies"
            }
        },

        computed: {
            data() {
                return this.$store.getters[`${this.vuexNamespace}/data`]
            },

            formTitle() {
                return this.isEditing ? this.$vuetify.lang.t('$vuetify.word.edit.edit') : this.$vuetify.lang.t('$vuetify.word.create.create');
            },

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

            errors() {
                return this.$store.getters[`${this.vuexNamespace}/errors`]
            },

            isEditing() {
                return this.$store.getters[`${this.vuexNamespace}/isEditing`]
            },
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/addLoadAction`, {
                actionType: 'show',
                action: async ({commit, dispatch}, params) => {
                    await dispatch('company/getOne', params.id, {root: true})

                    commit('setShow', params.id)
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
        },

        methods: {
            async save() {
                if (this.isEditing) {
                    await this.$store.dispatch(`${this.vuexNamespace}/update`, this.data)
                } else {
                    await this.$store.dispatch(`${this.vuexNamespace}/create`, this.data)
                }

                this.$refs.server.getData();
            },

            async destroy() {
                await this.$store.dispatch(`${this.vuexNamespace}/destroy`)

                this.$refs.server.getData();
            },
        }
    }
</script>
