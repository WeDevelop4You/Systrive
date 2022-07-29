import SkeletonDataTable from "../layout/Skeletons/SkeletonDataTable";

export default {
    components: {
        SkeletonDataTable,

        Btn: () => import(/* webpackChunkName: "components/buttons/btn" */ '../components/Buttons/Btn'),
        IconBtn: () => import(/* webpackChunkName: "components/buttons/icon_btn" */ '../components/Buttons/IconBtn'),
        MultipleBtn: () => import(/* webpackChunkName: "components/buttons/multiple_btn" */ '../components/Buttons/MultipleBtn'),

        Badge: () => import(/* webpackChunkName: "components/items/badge" */ '../components/Items/Badge'),
        GroupBadges: () => import(/* webpackChunkName: "components/items/group_badges" */ '../components/Items/GroupBadges'),

        SelectInput: () => import(/* webpackChunkName: "components/forms/input_types/select_input" */ '../components/Forms/InputTypes/SelectInput')
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

        this.$routeLoader.runStateAction(this.vuexNamespace)
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
