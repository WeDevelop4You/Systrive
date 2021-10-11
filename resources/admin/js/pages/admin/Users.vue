<template>
    <server-data-table ref="table" :custom-items="customItems" :title="$vuetify.lang.t('$vuetify.word.accounts')" :headers="headers" :route="$api.route('admin.users')" vuex-getter="accounts/all" vuex-commit="accounts/setAccounts" searchable>
        <template v-slot:toolbar.append>
            <edit-dialog :button-title="$vuetify.lang.t('$vuetify.word.new.account')" :form-title="formTitle" vuex-namespace="accounts" disable-create fullscreen @save="save">

            </edit-dialog>
        </template>
        <template v-slot:delete>
            <delete-dialog :title="$vuetify.lang.t('$vuetify.word.account.delete')" vuex-namespace="accounts" force-deletable @delete="destroy" @force-delete="forceDestroy"></delete-dialog>
        </template>
    </server-data-table>
</template>

<script>
    import ServerDataTable from "../../components/ServerDataTable";
    import Actions from "../../components/table/accounts/Actions";
    import {mapGetters} from "vuex";
    import EditDialog from "../../components/table/EditDialog";
    import DeleteDialog from "../../components/table/DeleteDialog";

    export default {
        name: "Users",

        components: {
            DeleteDialog,
            EditDialog,
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
            formTitle() {
                return 'test'
            },

            headers() {
                return [
                    {text: 'ID', value: 'id', sortable: true, align: 'start'},
                    {text: 'Name', value: 'profile.full_name', sortable: true},
                    {text: 'E-mail', value: 'email', sortable: true},
                    {text: 'E-mail verified at', value: 'email_verified_at', sortable: true},
                    {text: 'Created at', value: 'created_at', sortable: true},
                    {text: 'Actions', value: 'actions', sortable: false, align: 'end'},
                ]
            },

            ...mapGetters({
                account: 'accounts/selected',
            })
        },

        methods: {
            save() {
                console.log('test')
            },

            async destroy() {
                await this.$store.dispatch('accounts/destroy')
                this.$refs.table.getData()
            },

            async forceDestroy() {
                await this.$store.dispatch('accounts/forceDestroy')
                this.$refs.table.getData()
            }
        }
    }
</script>
