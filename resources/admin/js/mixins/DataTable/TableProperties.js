export default {
    props: {
        title: {
            required: true,
            type: String
        },

        vuexNamespace: {
            required: true,
            type: String
        },

        searchable: {
            type: Boolean,
            default: false
        },

        customItems: {
            type: Array,
            default: () => [],
        },

        itemsPerPageOptions: {
            type: Array,
            default: () => [
                10,
                25,
                50
            ]
        },

        refreshButton: {
            type: Boolean,
            default: false
        },

        doLoadAction: {
            type: Boolean,
            default: true,
        }
    },

    data() {
        return {
            search: '',
        }
    },

    computed: {
        headers() {
            return this.$store.getters[`${this.vuexNamespace}/headers`]
        },

        items() {
            return this.$store.getters[`${this.vuexNamespace}/items`]
        },

        total() {
            return this.$store.getters[`${this.vuexNamespace}/total`]
        }
    },

    created() {
        if (this.doLoadAction) {
            this.$store.dispatch(`${this.vuexNamespace}/load`)
        } else {
            this.$store.commit(`${this.vuexNamespace}/useActions`, this.doLoadAction)
        }
    },

    methods: {
        load() {
            this.$store.dispatch(`${this.vuexNamespace}/getItems`)
        },

        reset() {
            this.page = 1
            this.search = ''
            this.sorting = []
            this.itemsPerPage = 10

            this.generateParams()
        }
    }
}
