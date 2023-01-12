<template>
    <div>
        <template v-if="!chartData.length">
            <SkeletonChart />
        </template>
        <component
            :is="component.data.type"
            v-show="chartData.length"
            :labels="labels"
            :chart-data="chartData"
        />
    </div>
</template>

<script>
    import SkeletonChart from "../../Layout/Skeletons/SkeletonChart.vue";
    import ComponentError from "../ComponentError.vue";
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Chart",

        components: {
            SkeletonChart,

            SystemUsagesComponent: () => ({
                component: import('../../../App/Company/Layout/Charts/SystemUsages.vue'),
                loading: SkeletonChart,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
        },

        extends: ComponentBase,

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
                    url: this.component.data.url,
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
