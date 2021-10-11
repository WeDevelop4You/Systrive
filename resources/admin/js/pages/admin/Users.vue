<template>
    <server-data-table :custom-items="customItems" :title="$vuetify.lang.t('$vuetify.word.accounts')" :headers="headers" :route="$api.route('admin.users')" vuex-getter="accounts/all" vuex-commit="accounts/setAccounts" searchable>
        <template v-slot:toolbar.append>
            <v-btn color="primary" class="mb-2 ml-4" @click="open">{{ $vuetify.lang.t('$vuetify.word.new.account') }}</v-btn>
            <v-dialog :value="dialog" max-width="700px" persistent>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                        <v-spacer/>
                        <v-btn icon @click="close">
                            <v-icon>fas fa-times</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        {{ account || 'test' }}
                    </v-card-text>
                    <v-card-actions class="px-6">
                        <v-spacer></v-spacer>
                        <v-btn text @click="close" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.cancel') }}</v-btn>
                        <v-btn color="primary" @click="save" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.save') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>
    </server-data-table>
</template>

<script>
    import ServerDataTable from "../../components/ServerDataTable";
    import Actions from "../../components/table/accounts/Actions";
    import {mapGetters} from "vuex";

    export default {
        name: "Users",

        components: {
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
                dialog: 'accounts/dialog',
                account: 'accounts/selected',
            })
        },

        methods: {
            open() {
                this.$store.commit('accounts/changeDialog', true)
            },

            close() {
                this.$store.commit('accounts/changeDialog', false)
            },

            save() {

            }
        }
    }
</script>
