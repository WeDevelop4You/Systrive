<template>
    <server-data-table
        ref="server"
        :custom-items="customItems"
        :title="$vuetify.lang.t('$vuetify.word.companies')"
        :headers="headers"
        :route="$api.route('admin.companies')"
        vuex-namespace="companies"
        searchable
    >
        <template #toolbar.append>
            <create-or-edit-dialog
                :form-title="formTitle"
                :button-title="$vuetify.lang.t('$vuetify.word.create.company')"
                vuex-namespace="companies"
                @save="save"
                @open="dialogOpened"
            >
                <f-company v-model="data" />
            </create-or-edit-dialog>
        </template>
        <delete-dialog
            :title="$vuetify.lang.t('$vuetify.word.delete.account')"
            vuex-namespace="companies"
            @delete="destroy"
        />
        <show-dialog
            :title="$vuetify.lang.t('$vuetify.text.show.company')"
            vuex-namespace="companies"
        >
            <show />
        </show-dialog>
    </server-data-table>
</template>

<script>
    import {mapGetters} from "vuex";
    import ServerDataTable from "../../../components/ServerDataTable";
    import CreateOrEditDialog from "../../../components/table/CreateOrEditDialog";
    import DeleteDialog from "../../../components/table/DeleteDialog";
    import Actions from "../../../components/table/companies/Actions";
    import FCompany from "../../../layout/forms/Company";
    import Show from "./Show";
    import ShowDialog from "../../../components/table/ShowDialog";

    export default {
        name: "Index",

        components: {
            ShowDialog,
            Show,
            FCompany,
            DeleteDialog,
            ServerDataTable,
            CreateOrEditDialog,
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
                return this.isEditing ? this.$vuetify.lang.t('$vuetify.word.edit.edit') : this.$vuetify.lang.t('$vuetify.word.create.create');
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
                data: "companies/data",
                isEditing: "companies/isEditing",
            })
        },

        beforeCreate() {
            this.$store.commit('companies/changeAllowedLoadActionState', {actionName: 'show', allowed: true})

            this.$store.commit('companies/setStructure',{
                name: '',
                email: '',
                domain: '',
                information: '',
                owner: {},
            })
        },

        methods: {
            dialogOpened() {
                if (!this.isEditing) {
                    this.$store.dispatch('companies/userList', '')
                }
            },

            async save() {
                if (this.isEditing) {
                    await this.$store.dispatch('companies/update', this.data)
                } else {
                    await this.$store.dispatch('companies/create', this.data)
                }

                this.$refs.server.getData();
            },

            async destroy() {
                await this.$store.dispatch('companies/destroy')
                this.$refs.server.getData();
            },
        }
    }
</script>
