<template>
    <v-row>
        <v-col
            cols="12"
            md="6"
        >
            <v-card>
                <v-card-title />
                <v-card-text>
                    <line-chart
                        :custom-options="options"
                        :labels="chartData.labels"
                        :datasets="data"
                        style="height: 200px"
                    />
                </v-card-text>
            </v-card>
        </v-col>
        <v-col
            cols="12"
            md="6"
        >
            <v-card>
                <v-card-title />
                <v-card-text>
                    <line-chart
                        :custom-options="options"
                        :labels="chartData.labels"
                        :datasets="data2"
                        style="height: 200px"
                    />
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import LineChart from "../../../components/charts/LineChart";

    export default {
        name: "Index",

        components: {
            LineChart
        },

        data() {
            return {
                options: {
                    tooltips: {
                        displayColors: false
                    }
                },
                chartData: {}
            }
        },

        computed: {
            data() {
                return  [
                    {
                        label: this.$vuetify.lang.t('$vuetify.word.usage.disk'),
                        borderWidth: 1,
                        borderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBorderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBackgroundColor: this.$vuetify.theme.dark ? '#1e1e1e' : '#ffffff',
                        backgroundColor: 'transparent',
                        data: this.chartData.data.disk
                    }
                ]
            },

            data2() {
                return  [
                    {
                        label: this.$vuetify.lang.t('$vuetify.word.usage.bandwidth'),
                        borderWidth: 1,
                        borderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBorderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBackgroundColor: this.$vuetify.theme.dark ? '#1e1e1e' : '#ffffff',
                        backgroundColor: 'transparent',
                        data: this.chartData.data.bandwidth
                    }
                ]
            }
        },

        beforeCreate() {
            let app = this

            this.$api.call({
                url: app.$api.route('company.domain.usage', 3, 7),
                method: "GET"
            }).then((response) => {
                app.chartData = response.data.data
            })
        }
    }
</script>
