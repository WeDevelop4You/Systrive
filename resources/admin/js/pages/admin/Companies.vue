<template>
    <server-data-table ref="server" :custom-items="customItems" :title="$vuetify.lang.t('$vuetify.word.companies')" :headers="headers" :route="$api.route('admin.companies')" vuex-namespace="companies" searchable>
        <template v-slot:toolbar.append>
            <edit-dialog :form-title="formTitle" vuex-namespace="companies" fullscreen @save="save">

            </edit-dialog>
        </template>
        <template v-slot:delete>
            <delete-dialog :title="$vuetify.lang.t('$vuetify.word.delete.account')" vuex-namespace="companies" @delete="destroy"></delete-dialog>
        </template>
    </server-data-table>
</template>

<script>
    import {mapGetters} from "vuex";
    import ServerDataTable from "../../components/ServerDataTable";
    import EditDialog from "../../components/table/EditDialog";
    import DeleteDialog from "../../components/table/DeleteDialog";
    import Actions from "../../components/table/companies/Actions";

    export default {
        name: "Companies",

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
                return 'test';
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

            ...mapGetters({

            })
        },

        methods: {
            save() {

            },

            destroy() {

            },
        }
    }
</script>
