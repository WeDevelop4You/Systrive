<template>
    <server-data-table
        ref="server"
        :route="route"
        :headers="headers"
        :custom-items="customItems"
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

        mixins: [
            DeleteProperties,
            CreateOrEditProperties
        ],

        components: {
            DeleteModal,
            ServerDataTable,
            CreateOrEditModal
        },

        data() {
            return {
                customItems: [
                    {name: 'actions', component: Actions}
                ],

                vuexNamespace: 'users',
                route: this.$api.route('admin.users')
            }
        },

        computed: {
            headers() {
                return [
                    {text: this.$vuetify.lang.t('$vuetify.word.id'), value: 'id', sortable: true, align: 'start'},
                    {text: this.$vuetify.lang.t('$vuetify.word.name'), value: 'profile.full_name', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.email'), value: 'email', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.email_verified_at'), value: 'email_verified_at', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.created_at'), value: 'created_at', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.deleted_at'), value: 'deleted_at', sortable: true, divider: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: 'end'},
                ]
            }
        }
    }
</script>
