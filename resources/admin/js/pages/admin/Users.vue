<template>
    <server-data-table
        ref="server"
        :custom-items="customItems"
        :title="$vuetify.lang.t('$vuetify.word.users')"
        :headers="headers"
        :route="$api.route('admin.users')"
        vuex-namespace="users"
        searchable
    >
        <template #toolbar.append>
            <create-or-edit-dialog
                :form-title="$vuetify.lang.t('$vuetify.word.edit.user')"
                vuex-namespace="users"
                disable-create
                fullscreen
                @save="save"
            />
        </template>
        <delete-dialog
            :title="$vuetify.lang.t('$vuetify.word.delete.user')"
            vuex-namespace="users"
            force-deletable
            @delete="destroy"
            @force-delete="forceDestroy"
        />
    </server-data-table>
</template>

<script>
    import ServerDataTable from "../../components/ServerDataTable";
    import Actions from "../../components/table/users/admin/Actions";
    import CreateOrEditDialog from "../../components/table/CreateOrEditDialog";
    import DeleteDialog from "../../components/table/DeleteDialog";

    export default {
        name: "Users",

        components: {
            DeleteDialog,
            CreateOrEditDialog,
            ServerDataTable
        },

        data() {
            return {
                customItems: [
                    {name: 'actions', component: Actions}
                ]
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
                    {text: this.$vuetify.lang.t('$vuetify.word.deleted_at'), value: 'deleted_at', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: 'end'},
                ]
            }
        },

        methods: {
            save() {
                console.log('test')
            },

            async destroy() {
                await this.$store.dispatch('users/destroy')
                this.$refs.server.getData()
            },

            async forceDestroy() {
                await this.$store.dispatch('users/forceDestroy')
                this.$refs.server.getData()
            }
        }
    }
</script>
