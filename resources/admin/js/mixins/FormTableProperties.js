export default {
    computed: {
        data() {
            return this.$store.getters[`${this.vuexNamespace}/data`]
        },

        errors() {
            return this.$store.getters[`${this.vuexNamespace}/errors`]
        },

        isEditing() {
            return this.$store.getters[`${this.vuexNamespace}/isEditing`]
        }
    }
}
