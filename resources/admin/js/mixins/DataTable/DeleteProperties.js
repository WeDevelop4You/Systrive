export default {
    data() {
        return {
            deleteTitle: this.$vuetify.lang.t('$vuetify.word.delete.delete')
        }
    },

    computed: {
        showDelete: {
            get() {
                return this.$store.getters[`${this.vuexNamespace}/isDeleteModalOpen`]
            },

            set(value) {
                !value ? this.$store.commit(`${this.vuexNamespace}/resetDelete`) : undefined
            }
        },

        deleteContent() {
            return this.$store.getters[`${this.vuexNamespace}/deleteMessage`]
        },

        isDeleted() {
            return this.$store.getters[`${this.vuexNamespace}/isDeleted`]
        }
    },

    mounted() {
        this.$refs.delete.$on('destroy', this.destroy)
        this.$refs.delete.$on('forceDestroy', this.forceDestroy)
    },

    methods: {
        async destroy() {
            await this.$store.dispatch(`${this.vuexNamespace}/destroy`)

            this.$refs.server.getData()
        },

        async forceDestroy() {
            await this.$store.dispatch(`${this.vuexNamespace}/forceDestroy`)

            this.$refs.server.getData()
        }
    }
}
