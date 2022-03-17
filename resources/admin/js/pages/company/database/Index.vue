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
    </v-row>
</template>

<script>
    import CardBase from "../../../components/cards/CardBase";
    import LineChart from "../../../components/charts/LineChart";
    import DetailsCard from "../../../components/cards/DetailsCard";
    import CreateOrEditModal from "../../../components/modals/CreateOrEditModal";
    import {mapGetters} from "vuex";

    export default {
        name: "Index",

        components: {
            CardBase,
            LineChart,
            DetailsCard,
            CreateOrEditModal
        },

        beforeRouteUpdate(to, from, next) {
            this.$store.commit('company/system/database/reset')

            this.setup(to.params.databaseName)

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

            ...mapGetters({
                chartData: 'company/system/database/chartData',
                listDetails: 'company/system/database/listDetails'
            })
        },

        created() {
            this.setup(this.$route.params.databaseName)
        },

        methods: {
            setup(database) {
                this.$store.dispatch('company/system/database/search', database)
            }
        }
    }
</script>
