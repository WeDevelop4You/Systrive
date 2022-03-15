<template>
    <server-data-table
        :item-route="routes.items"
        :custom-items="customItems"
        :do-load-action="allowAction"
        :header-route="routes.headers"
        :vuex-namespace="vuexNamespace"
        :title="$vuetify.lang.t('$vuetify.word.roles')"
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
            routes() {
                return {
                    items: this.$api.route('company.role.table.items', this.$store.getters['company/id']),
                    headers: this.$api.route('company.role.table.headers', this.$store.getters['company/id']),
                }
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
    }
</script>
