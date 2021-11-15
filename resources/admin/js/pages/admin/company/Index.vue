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
        <template #toolbar.append>
            <create-or-edit-dialog
                :form-title="formTitle"
                :button-title="$vuetify.lang.t('$vuetify.word.create.company')"
                vuex-namespace="companies"
                @save="save"
                @open="dialogOpened"
            >
                <f-company v-model="data" />
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
    import ServerDataTable from "../../../components/ServerDataTable";
    import CreateOrEditDialog from "../../../components/table/CreateOrEditDialog";
    import DeleteDialog from "../../../components/table/DeleteDialog";
    import Actions from "../../../components/table/companies/Actions";
    import FCompany from "../../../layout/forms/Company";
    import Show from "./Show";
    import ShowDialog from "../../../components/table/ShowDialog";

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
                    {text: this.$vuetify.lang.t('$vuetify.word.domain'), value: 'domain', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.created_at'), value: 'created_at', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: 'end'},
                ]
            },

            isEditing() {
                return this.$store.getters[`${this.vuexNamespace}/isEditing`]
            },
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/addLoadAction`, {
                actionName: 'show',
                action: {
                    isAllowed: true,
                    isIdAllowed: true,
                    func: async ({commit, dispatch}, id) => {
                        await dispatch('company/getOne', id, {root: true})

                        commit('setShow', id)
                    }
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
            dialogOpened() {
                if (!this.isEditing) {
                    this.$store.dispatch(`${this.vuexNamespace}/searchList`, '')
                }
            },

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
