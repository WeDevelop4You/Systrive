import { Line } from 'vue-chartjs'
import _ from "lodash";

export default {
    extends: Line,

    props: {
        labels: {
            required: true,
            type: Array
        },

        datasets: {
            type: Array | Object,
            required: false
        },

        customOptions: {
            type: Object,
            default: () => {
                return {}
            }
        }
    },

    data() {
        return {
            chart: null,
            defaultOptions: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false,
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },

    computed: {
        options() {
            let options = _.merge(this.defaultOptions, this.customOptions)

            const zeroLineColor =  this.$vuetify.theme.dark ? '#545454' : '#dfdfdf'
            const gridLinesColor =  this.$vuetify.theme.dark ? '#393939' : '#e5e5e5'

            Object.assign(options.scales.yAxes[0], {
                gridLines: {
                    color: gridLinesColor,
                    zeroLineColor: zeroLineColor
                }
            })

            return options
        }
    },

    watch: {
        labels: {
            handler() {
                this.chart.data.labels = this.labels
                this.chart.update()
            },
            deep: true
        },

        datasets: {
            handler() {
                this.chart.data.datasets = this.datasets
                this.chart.update()
            },
            deep: true
        },

        options: {
            handler() {
                this.chart.options = this.options
                this.chart.update()
            },
            deep: true
        }
    },

    mounted () {
        this.renderChart({
            labels: this.labels,
            datasets: this.datasets
        }, this.options)

        this.chart = this.$data._chart
    }
}
