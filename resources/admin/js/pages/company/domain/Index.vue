<template>
    <v-row>
        <v-col
            cols="12"
            md="6"
        >
            <v-card
                :elevation="$config.elevation"
                outlined
                rounded="lg"
            >
                <v-card-title>
                    <span v-text="$vuetify.lang.t('$vuetify.word.usage.disk')" />
                </v-card-title>
                <v-card-text>
                    <line-chart
                        :custom-options="options"
                        :labels="chartData.labels"
                        :datasets="diskData"
                        style="height: 200px"
                    />
                </v-card-text>
            </v-card>
        </v-col>
        <v-col
            cols="12"
            md="6"
        >
            <v-card
                :elevation="$config.elevation"
                outlined
                rounded="lg"
            >
                <v-card-title>
                    <span v-text="$vuetify.lang.t('$vuetify.word.usage.bandwidth')" />
                </v-card-title>
                <v-card-text>
                    <line-chart
                        :custom-options="options"
                        :labels="chartData.labels"
                        :datasets="bandwidthData"
                        style="height: 200px"
                    />
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import LineChart from "../../../components/charts/LineChart";
    import {mapGetters} from "vuex";

    export default {
        name: "Index",

        components: {
            LineChart
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
