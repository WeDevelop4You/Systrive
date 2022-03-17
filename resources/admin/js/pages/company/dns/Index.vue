<template>
    <v-row>
        <v-col cols="12">
            <details-card
                v-model="listDetails"
                :title="$vuetify.lang.t('$vuetify.details')"
            >
                <template #edit>
                    <create-or-edit-modal
                        v-model="modal"
                        title="test"
                        button-type="icon"
                    >
                        <template #button>
                            <v-btn
                                icon
                                :disabled="$loading"
                                @click="modal = true"
                            >
                                <v-icon>fas fa-pen</v-icon>
                            </v-btn>
                        </template>
                        abdawbd
                    </create-or-edit-modal>
                </template>
            </details-card>
        </v-col>
        <v-col cols="12">
            <locale-data-table
                :custom-items="customItems"
                :vuex-namespace="vuexNamespace"
                :title="$vuetify.lang.t('$vuetify.word.records')"
                searchable
            />
        </v-col>
    </v-row>
</template>

<script>
    import DetailsCard from "../../../components/cards/DetailsCard";
    import CreateOrEditModal from "../../../components/modals/CreateOrEditModal";
    import LocaleDataTable from "../../../components/table/LocaleDataTable";
    import Active from "../../../components/table/column/company/system/Active";
    import Actions from "../../../components/table/column/company/system/dns/Actions";

    export default {
        name: "Index",

        components: {
            DetailsCard,
            LocaleDataTable,
            CreateOrEditModal
        },

        beforeRouteUpdate(to, from, next) {
            this.$store.commit(`${this.vuexNamespace}/reset`)

            this.setup(to.params.domainNameServer)

            next()
        },

        data() {
            return {
                customItems: [
                    {name: 'suspended', component: Active},
                    {name: 'actions', component: Actions},
                ],

                modal: false,
                vuexNamespace: 'company/system/dns'
            }
        },

        computed: {
            listDetails() {
                return this.$store.getters[`${this.vuexNamespace}/listDetails`]
            },
        },

        created() {
            this.setup(this.$route.params.domainNameServer)
        },

        methods: {
            async setup(dns) {
                await this.$store.dispatch(`${this.vuexNamespace}/search`, dns)
            }
        }
    }
</script>
