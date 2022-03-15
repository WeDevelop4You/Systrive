<template>
    <server-data-table
        :item-route="routes.items"
        :custom-items="customItems"
        :do-load-action="allowAction"
        :header-route="routes.headers"
        :vuex-namespace="vuexNamespace"
        :title="$vuetify.lang.t('$vuetify.word.user.access')"
        searchable
    >
        <template #toolbar.prepend>
            <create-or-edit-modal
                ref="createOrEdit"
                v-model="showCreateOrEdit"
                :title="title"
                rerender
            >
                <template
                    v-if="$auth.can($config.permissions.user.invite)"
                    #button
                >
                    <default-button
                        :content="$vuetify.lang.t('$vuetify.word.invite.invite')"
                        @click="openCreate"
                    />
                </template>
                <company-user
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
            :title="$vuetify.lang.t('$vuetify.word.revoke.user')"
        />
    </server-data-table>
</template>

<script>
    import CompanyUser from "../forms/company/CompanyUser";
    import Index from "../../components/table/column/Index";
    import Status from "../../components/table/column/Status";
    import DefaultButton from "../../components/DefaultButton";
    import DeleteModal from "../../components/modals/DeleteModal";
    import ServerDataTable from "../../components/table/ServerDataTable";
    import DeleteProperties from "../../mixins/DataTable/DeleteProperties";
    import CreateOrEditModal from "../../components/modals/CreateOrEditModal";
    import Actions from "../../components/table/column/company/access/Actions";
    import CreateOrEditProperties from "../../mixins/DataTable/CreateOrEditProperties";

    export default {
        name: "UserAccess",

        components: {
            CompanyUser,
            DeleteModal,
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
                    {name: 'status', component: Status},
                    {name: 'actions', component: Actions},
                ],

                vuexNamespace: 'company/users',
            }
        },

        computed: {
            routes() {
                return {
                    items: this.$api.route('company.user.table.items', this.$store.getters['company/id']),
                    headers: this.$api.route('company.user.table.headers', this.$store.getters['company/id']),
                }
            },

            allowAction() {
                return this.$store.getters['user/permissions/getType'] === this.$config.permissions.types.company
            },

            title() {
                return this.isEditing
                    ? this.$vuetify.lang.t('$vuetify.word.edit.edit')
                    : this.$vuetify.lang.t('$vuetify.word.invite.invite');
            },
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/setStructure`, {
                email: "",
                roles: [],
                permissions: [],
            });
        },
    }
</script>
