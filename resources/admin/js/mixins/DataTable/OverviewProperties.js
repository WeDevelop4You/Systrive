export default {
    computed: {
        showOverview: {
            get() {
                return this.$store.getters[`${this.vuexNamespace}/isOverviewModalOpen`]
            },

            set(value) {
                !value ? this.$store.commit(`${this.vuexNamespace}/resetOverview`) : undefined
            }
        }
    }
}
