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
            const item = this.$store.getters[`${this.vuexNamespace}/deleteItem`]

            return this.$vuetify.lang.t('$vuetify.text.delete.delete', item)
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
            await this.$store.dispatch(`${this.vuexNamespace}/getMany`)
        },

        async forceDestroy() {
            await this.$store.dispatch(`${this.vuexNamespace}/forceDestroy`)
            await this.$store.dispatch(`${this.vuexNamespace}/getMany`)
        }
    }
}
