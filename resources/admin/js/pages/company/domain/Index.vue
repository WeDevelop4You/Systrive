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
            md="6"
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
        <v-col
            cols="12"
            md="6"
        >
            <card-base
                :title="$vuetify.lang.t('$vuetify.word.usage.bandwidth')"
            >
                <line-chart
                    :custom-options="options"
                    :labels="chartData.labels"
                    :datasets="bandwidthData"
                    style="height: 200px"
                />
            </card-base>
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import CardBase from "../../../components/cards/CardBase";
    import LineChart from "../../../components/charts/LineChart";
    import DetailsCard from "../../../components/cards/DetailsCard";
    import CreateOrEditModal from "../../../components/modals/CreateOrEditModal";

    export default {
        name: "Index",

        components: {
            CardBase,
            LineChart,
            DetailsCard,
            CreateOrEditModal
        },

        beforeRouteUpdate(to, from, next) {
            this.$store.commit('company/system/domain/reset')

            this.setup(to.params.domainName)

            next()
        },

        data() {
            return {
                options: {
                    tooltips: {
                        displayColors: false
                    }
                },

                modal: false
            }
        },

        computed: {
            diskData() {
                return  [
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

            bandwidthData() {
                return  [
                    {
                        label: this.$vuetify.lang.t('$vuetify.word.usages'),
                        borderWidth: 1,
                        borderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBorderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBackgroundColor: this.$vuetify.theme.currentTheme.chartPoint,
                        backgroundColor: 'transparent',
                        data: this.chartData.data.bandwidth
                    }
                ]
            },

            ...mapGetters({
                chartData: 'company/system/domain/chartData',
                listDetails: 'company/system/domain/listDetails'
            })
        },

        created() {
            this.setup(this.$route.params.domainName)
        },

        methods: {
            setup(domain) {
                this.$store.dispatch('company/system/domain/search', domain)
            }
        }
    }
</script>
