<template>
    <server-data-table
        ref="server"
        :custom-items="customItems"
        :title="$vuetify.lang.t('$vuetify.word.user.access')"
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
                :create-permission="$config.permissions.user.invite"
                :button-title="$vuetify.lang.t('$vuetify.word.invite.user')"
                rerender
                @save="save"
            >
                <company-user
                    v-model="data"
                    :is-editing="isEditing"
                    :errors="errors"
                />
            </create-or-edit-dialog>
        </template>
        <delete-dialog
            :title="$vuetify.lang.t('$vuetify.word.revoke.user')"
            :vuex-namespace="vuexNamespace"
            @delete="destroy"
        />
    </server-data-table>
</template>

<script>
    import Index from "../../components/table/column/Index";
    import Chip from "../../components/table/column/Chip";
    import CompanyUser from "../forms/company/CompanyUser";
    import DeleteDialog from "../../components/table/DeleteDialog";
    import ServerDataTable from "../../components/table/ServerDataTable";
    import Actions from "../../components/table/column/company/access/Actions";
    import CreateOrEditDialog from "../../components/table/CreateOrEditDialog";
    import FormProperties from "../../mixins/FormTableProperties";

    export default {
        name: "UserAccess",

        components: {
            CompanyUser,
            CreateOrEditDialog,
            DeleteDialog,
            ServerDataTable
        },

        mixins: [
            FormProperties
        ],

        data() {
            return {
                customItems: [
                    {name: 'index', component: Index},
                    {name: 'status', component: Chip},
                    {name: 'actions', component: Actions},
                ],

                vuexNamespace: 'company/users',
            }
        },

        computed: {
            route() {
                return this.$api.route('company.users', this.$store.getters['company/id']);
            },

            headers() {
                return [
                    {text: '#', value: 'index', align: 'start'},
                    {text: this.$vuetify.lang.t('$vuetify.word.name'), value: 'profile.full_name', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.email'), value: 'email', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.status'), value: 'status', sortable: true, divider: this.showActions()},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: this.showActions() ? 'end' : ' d-none'},
                ]
            },

            allowAction() {
                return this.$store.getters['user/permissions/getType'] === this.$config.permissions.types.company
            },

            formTitle() {
                return this.isEditing ? this.$vuetify.lang.t('$vuetify.word.edit.edit') : this.$vuetify.lang.t('$vuetify.word.invite.invite');
            },
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/setStructure`, {
                email: "",
                roles: [],
                permissions: [],
            });
        },

        methods: {
            async save() {
                if (this.isEditing) {
                    await this.$store.dispatch(`${this.vuexNamespace}/update`, this.data)
                } else {
                    await this.$store.dispatch(`${this.vuexNamespace}/invite`, this.data)
                }

                this.$refs.server.getData();
            },

            async destroy() {
                await this.$store.dispatch(`${this.vuexNamespace}/revoke`)
                this.$refs.server.getData();
            },

            showActions() {
                const permissions = this.$config.permissions

                return this.$auth.can([
                    permissions.user.invite,
                    permissions.user.revoke,
                    permissions.user.editRoles,
                ])
            }
        }
    }
</script>
