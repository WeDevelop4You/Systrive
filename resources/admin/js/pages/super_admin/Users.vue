<template>
    <server-data-table
        :item-route="routes.items"
        :custom-items="customItems"
        :header-route="routes.headers"
        :vuex-namespace="vuexNamespace"
        :title="$vuetify.lang.t('$vuetify.word.users')"
        searchable
    >
        <template #toolbar.prepend>
            <create-or-edit-modal
                ref="createOrEdit"
                v-model="showCreateOrEdit"
                :title="$vuetify.lang.t('$vuetify.word.edit.user')"
            />
        </template>
        <delete-modal
            ref="delete"
            v-model="showDelete"
            :title="deleteTitle"
            :is-deleted="isDeleted"
            :content="deleteContent"
            force-deletable
        />
    </server-data-table>
</template>

<script>
    import DeleteModal from "../../components/modals/DeleteModal";
    import ServerDataTable from "../../components/table/ServerDataTable";
    import DeleteProperties from "../../mixins/DataTable/DeleteProperties";
    import Actions from "../../components/table/column/users/admin/Actions";
    import CreateOrEditModal from "../../components/modals/CreateOrEditModal";
    import CreateOrEditProperties from "../../mixins/DataTable/CreateOrEditProperties";

    export default {
        name: "Users",

        components: {
            DeleteModal,
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
                    {name: 'actions', component: Actions}
                ],

                vuexNamespace: 'users',
                routes: {
                    items: this.$api.route('admin.user.table.items'),
                    headers: this.$api.route('admin.user.table.headers')
                }
            }
        },
    }
</script>
