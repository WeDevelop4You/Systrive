<template>
    <server-data-table
        ref="server"
        :custom-items="customItems"
        :title="$vuetify.lang.t('$vuetify.word.user.access')"
        :headers="headers"
        :route="route"
        :do-load-action="false"
        :vuex-namespace="vuexNamespace"
        searchable
    >
        <template #toolbar.append>
            <create-or-edit-dialog
                :form-title="formTitle"
                :button-title="$vuetify.lang.t('$vuetify.word.invite.user')"
                :vuex-namespace="vuexNamespace"
                rerender
                @save="save"
            >
                <company-user v-model="data" />
            </create-or-edit-dialog>
        </template>
        <delete-dialog
            :title="$vuetify.lang.t('$vuetify.word.revoke.user')"
            :vuex-namespace="vuexNamespace"
            @destroy="destroy"
        />
    </server-data-table>
</template>

<script>
    import ServerDataTable from "../../components/ServerDataTable";
    import Actions from "../../components/table/users/access/Actions";
    import DeleteDialog from "../../components/table/DeleteDialog";
    import CreateOrEditDialog from "../../components/table/CreateOrEditDialog";
    import CompanyUser from "../forms/CompanyUser";

    export default {
        name: "UserAccess",

        components: {
            CompanyUser,
            CreateOrEditDialog,
            DeleteDialog,
            ServerDataTable
        },

        data() {
            return {
                customItems: [
                    {name: 'actions', component: Actions}
                ],

                vuexNamespace: 'company/users',
            }
        },

        computed: {
            data() {
                return this.$store.getters[`${this.vuexNamespace}/data`]
            },

            route() {
                return this.$api.route('company.users', this.$store.getters['company/id']);
            },

            headers() {
                return [
                    {text: this.$vuetify.lang.t('$vuetify.word.name'), value: 'profile.full_name', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.email'), value: 'email', sortable: true},
                    {text: this.$vuetify.lang.t('$vuetify.word.actions'), value: 'actions', sortable: false, align: 'end'},
                ]
            },

            isEditing() {
                return this.$store.getters[`${this.vuexNamespace}/isEditing`]
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
                await this.$store.dispatch(`${this.vuexNamespace}/destroy`)
                this.$refs.server.getData();
            },
        }
    }
</script>
