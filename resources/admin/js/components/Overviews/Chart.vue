<template>
    <div>
        <template v-if="!chartData.length">
            <SkeletonChart />
        </template>
        <component
            :is="value.data.type"
            v-show="chartData.length"
            :labels="labels"
            :chart-data="chartData"
        />
    </div>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import SkeletonChart from "../../layout/Skeletons/SkeletonChart.vue";
    import ComponentError from "../ComponentError.vue";

    export default {
        name: "Chart",

        components: {
            SkeletonChart,

            SystemUsages: () => ({
                component: import('../../layout/Charts/SystemUsages.vue'),
                loading: SkeletonChart,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
        },

        mixins: [
            ComponentProperties
        ],

        data() {
            return {
                labels: [],
                chartData: []
            }
        },

        created() {
            this.getData()
        },

        methods: {
            getData() {
                this.$api.call({
                    url: this.value.data.url,
                    method: "GET",
                }).then((response) => {
                    const chart = response.data.data

                    this.labels = chart.labels
                    this.chartData = chart.data
                })
            }
        }
    }
</script>
