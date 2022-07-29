<template>
    <line-chart
        :custom-options="options"
        :labels="labels"
        :datasets="dataset"
        style="height: 200px"
    />
</template>

<script>
    import LineChart from "../../components/Charts/LineChart";

    export default {
        name: "SystemUsages",

        components: {
            LineChart
        },

        props: {
            labels: {
                required: true,
                type: Array
            },

            chartData: {
                required: true,
                type: Array
            }
        },

        data() {
            return {
                options: {
                    tooltips: {
                        displayColors: false,
                        callbacks: {
                            label: this.createLabelCallback()
                        }
                    }
                }
            }
        },

        computed: {
            dataset() {
                return  [
                    {
                        label: this.$vuetify.lang.t('$vuetify.word.usage.usage'),
                        borderWidth: 1,
                        borderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBorderColor: this.$vuetify.theme.currentTheme.primary,
                        pointBackgroundColor: this.$vuetify.theme.currentTheme.chartPoint,
                        backgroundColor: 'transparent',
                        data: this.chartData
                    }
                ]
            },
        },

        methods: {
            createLabelCallback() {
                return function (tooltipItem, data) {
                    let format = 'MB'
                    let value = tooltipItem.yLabel
                    let label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label += ': ';
                    }

                    if (value >= 1000) {
                        format = 'GB'
                        value = (value / 1024).toFixed(2)
                    }

                    return `${label}${value} ${format}`;
                }
            }
        }
    }
</script>
