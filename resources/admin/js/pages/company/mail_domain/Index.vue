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
        <v-col
            cols="12"
        >
            <card-base
                :title="$vuetify.lang.t('$vuetify.word.usage.disk')"
            >
                <line-chart
                    :custom-options="options"
                    :labels="chartData.labels"
                    :datasets="diskData"
                    style="height: 200px"
                />
            </card-base>
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
    import CardBase from "../../../components/cards/CardBase";
    import LineChart from "../../../components/charts/LineChart";
    import DetailsCard from "../../../components/cards/DetailsCard";
    import CreateOrEditModal from "../../../components/modals/CreateOrEditModal";
    import Index from "../../../components/table/column/Index";
    import Active from "../../../components/table/column/company/system/Active";
    import Actions from "../../../components/table/column/company/system/dns/Actions";
    import LocaleDataTable from "../../../components/table/LocaleDataTable";

    export default {
        name: "Index",

        components: {
            CardBase,
            LineChart,
            DetailsCard,
            LocaleDataTable,
            CreateOrEditModal
        },

        beforeRouteUpdate(to, from, next) {
            this.$store.commit(`${this.vuexNamespace}/reset`)

            this.setup(to.params.mailDomainName)

            next()
        },

        data() {
            return {
                customItems: [
                    {name: 'index', component: Index},
                    {name: 'forward_saved', component: Active},
                    {name: 'suspended', component: Active},
                    {name: 'actions', component: Actions},
                ],

                options: {
                    tooltips: {
                        displayColors: false
                    }
                },

                modal: false,
                vuexNamespace: 'company/system/mailDomain'
            }
        },

        computed: {
            diskData() {
                return [
                    {
                        label: this.$vuetify.lang.t('$vuetify.word.usages'),
                        borderWidth: 1,
                        borderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBorderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBackgroundColor: this.$vuetify.theme.currentTheme.chartPoint,
                        backgroundColor: 'transparent',
                        data: this.chartData.data.disk
                    }
                ]
            },

            chartData() {
                return this.$store.getters[`${this.vuexNamespace}/chartData`]
            },

            listDetails() {
                return this.$store.getters[`${this.vuexNamespace}/listDetails`]
            },
        },

        created() {
            this.setup(this.$route.params.mailDomainName)
        },

        methods: {
            setup(mailDomain) {
                this.$store.dispatch(`${this.vuexNamespace}/search`, mailDomain)
            }
        }
    }
</script>
