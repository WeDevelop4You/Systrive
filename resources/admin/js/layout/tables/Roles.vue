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
            <create-or-edit-modal
                ref="createOrEdit"
                v-model="showCreateOrEdit"
                :title="createOrEditTitle"
                rerender
            >
                <template
                    v-if="$auth.can($config.permissions.role.create)"
                    #button
                >
                    <default-button
                        :content="$vuetify.lang.t('$vuetify.word.create.create')"
                        @click="openCreate"
                    />
                </template>
                <company-role
                    v-model="data"
                    :errors="errors"
                />
            </create-or-edit-modal>
        </template>
        <delete-modal
            ref="delete"
            v-model="showDelete"
            :content="deleteContent"
            :title="deleteTitle"
        />
    </server-data-table>
</template>

<script>
    import Index from "../../components/table/column/Index"
    import DefaultButton from "../../components/DefaultButton"
    import DeleteModal from "../../components/modals/DeleteModal"
    import CompanyRole from "../../layout/forms/company/CompanyRole"
    import ServerDataTable from "../../components/table/ServerDataTable"
    import DeleteProperties from "../../mixins/DataTable/DeleteProperties"
    import Actions from "../../components/table/column/company/role/Actions"
    import CreateOrEditModal from "../../components/modals/CreateOrEditModal"
    import CreateOrEditProperties from "../../mixins/DataTable/CreateOrEditProperties"

    export default {
        name: "Roles",

        components: {
            DeleteModal,
            CompanyRole,
            DefaultButton,
            ServerDataTable,
            CreateOrEditModal
        },

        mixins: [
            DeleteProperties,
            CreateOrEditProperties
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
                return this.$store.getters['user/permissions/getType'] === this.$config.permissions.types.company
            },
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/setStructure`, {
                name: '',
                permissions: [],
            });
        },

        methods: {
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
