<template>
    <server-data-table
        ref="server"
        :custom-items="customItems"
        :title="$vuetify.lang.t('$vuetify.word.roles')"
        :headers="headers"
        :route="route"
        :do-load-action="allowAction"
        :vuex-namespace="vuexNamespace"
        searchable
    >
        <template #toolbar.prepend>
            <create-or-edit-dialog
                :form-title="formTitle"
                :vuex-namespace="vuexNamespace"
                :create-permission="$config.permissions.role.create"
                :button-title="$vuetify.lang.t('$vuetify.word.create.role')"
                rerender
                @save="save"
            >
                <company-role
                    v-model="data"
                    :errors="errors"
                />
            </create-or-edit-dialog>
        </template>
        <delete-dialog
            :title="$vuetify.lang.t('$vuetify.word.delete.role')"
            :vuex-namespace="vuexNamespace"
            @delete="destroy"
        />
    </server-data-table>
</template>

<script>
    import Index from "../../components/table/column";
    import DeleteDialog from "../../components/table/DeleteDialog"
    import CompanyRole from "../../layout/forms/company/CompanyRole"
    import ServerDataTable from "../../components/table/ServerDataTable"
    import Actions from "../../components/table/column/company/role/Actions"
    import CreateOrEditDialog from "../../components/table/CreateOrEditDialog"
    import FormProperties from  "../../mixins/FormProperties"

    export default {
        name: "Roles",

        components: {
            CompanyRole,
            DeleteDialog,
            ServerDataTable,
            CreateOrEditDialog
        },

        mixins: [
            FormProperties
        ],

        data() {
            return {
                customItems: [
                    {name: 'index', component: Index},
                    {name: 'actions', component: Actions}
                ],

                vuexNamespace: 'company/roles',
            }
        },

        computed: {
            route() {
                return this.$api.route('company.roles', this.$store.getters['company/id']);
            },

            headers() {
                return [
                    {text: '#', value: 'index', align: 'start'},
                    {text: this.$vuetify.lang.t('$vuetify.word.name'), value: 'name', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.total.permissions'), value: 'permissions_count', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.created_at'), value: 'created_at', sortable: true, divider: this.showActions()},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: this.showActions() ? 'end' : ' d-none'},
                ]
            },

            allowAction() {
                return this.$store.getters['user/getPermissionType'] === this.$config.permissions.types.company
            },

            formTitle() {
                return this.isEditing ? this.$vuetify.lang.t('$vuetify.word.edit.edit') : this.$vuetify.lang.t('$vuetify.word.create.create');
            },
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/setStructure`, {
                name: '',
                permissions: [],
            });
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

            showActions() {
                const permissions = this.$config.permissions

                return this.$auth.can([
                    permissions.role.edit,
                    permissions.role.delete,
                ])
            }
        }
    }
</script>
