import Helper from "../Providers/Helper";
import SkeletonDataTable from "../layout/Skeletons/SkeletonDataTable.vue";

export default {
    components: {
        SkeletonDataTable,

        Btn: () => import('../components/Buttons/Btn.vue'),
        IconBtn: () => import('../components/Buttons/IconBtn.vue'),
        MultipleBtn: () => import('../components/Buttons/MultipleBtn.vue'),

        Badge: () => import('../components/Items/Badge.vue'),
        GroupBadges: () => import('../components/Items/GroupBadges.vue'),

        SelectInput: () => import('../components/Forms/InputTypes/SelectInput.vue')
    },

    props: {
        value: {
            required: true,
            type: Object
        },

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

        this.$loader.runStateAction(Helper.getMainVuexNamespace(this.vuexNamespace))
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
