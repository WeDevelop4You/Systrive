import Import from "../../helpers/Import";
import MainComponentBase from "./MainComponentBase";
import SkeletonDataTable from "../../layout/Skeletons/SkeletonDataTable.vue";

export default {
    extends: MainComponentBase,

    components: {
        SkeletonDataTable,
    },

    props: {
        vuexNamespace: {
            required: true,
            type: String
        },

        searchable: {
            type: Boolean,
            default: false
        },

        totalPerPageOptions: {
            type: Array,
            default: () => [
                10,
                25,
                50
            ]
        },

        totalPerPage: {
            type: Number,
            default: 10,
        },

        refreshButton: {
            type: Boolean,
            default: false
        },
    },

    data() {
        return {
            search: '',
            sortBy: [],
            elevation: `elevation-${this.$config.elevation}`,
        }
    },

    computed: {
        headers() {
            return this.$store.getters[`${this.vuexNamespace}/headers`]
        },

        customItems() {
            return this.$store.getters[`${this.vuexNamespace}/customItems`]
        },

        items() {
            return this.$store.getters[`${this.vuexNamespace}/items`]
        },

        total() {
            return this.$store.getters[`${this.vuexNamespace}/total`]
        }
    },

    created() {
        this.unwatch = this.$store.watch(
            (state, getters) => getters[`${this.vuexNamespace}/status`],
            (status) => {
                switch (status) {
                    case 'reset_params':
                        this.resetParams()
                }
            },
        );

        this.$loader.runStateAction(Import.getMainVuexNamespace(this.vuexNamespace))
    },

    methods: {
        load() {
            this.$store.dispatch(`${this.vuexNamespace}/getItems`)
        },
    },

    beforeDestroy() {
        this.unwatch();

        this.$store.commit(`${this.vuexNamespace}/reset`)
    }
}
