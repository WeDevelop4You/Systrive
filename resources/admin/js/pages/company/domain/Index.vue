<template>
    <v-row>
        <v-col cols="8">
            <details-card
                v-model="domain.list_details"
                :title="$vuetify.lang.t('vuetify.details')"
            >
                <template #edit>
                    <create-or-edit-modal
                        v-model="dialog"
                        title="test"
                        button-type="icon"
                    >
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
                no-action
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
                no-action
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
            this.$store.commit('company/domain/reset')

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

                dialog: false
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
                domain: 'company/domain/data',
                chartData: 'company/domain/chartData'
            })
        },

        created() {
            this.setup(this.$route.params.domainName)
        },

        methods: {
            setup(domain) {
                this.$store.dispatch('company/domain/search', domain)
            }
        }
    }
</script>
