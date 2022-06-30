import FormMethods from "./FormMethods";

export default {
    mixins: [
        FormMethods
    ],

    props: {
        vuexNamespace: {
            required: true,
            type: String
        }
    },

    computed: {
        data: {
            get() {
                return this.$store.getters[`${this.vuexNamespace}/data`]
            },

            set(values) {
                this.$store.commit(`${this.vuexNamespace}/setData`, values)
            }
        },

        isEditing() {
            return this.$store.getters[`${this.vuexNamespace}/isEditing`]
        },

        error() {
            return this.$store.getters[`${this.vuexNamespace}/error`]
        },

        errors() {
            return this.$store.getters[`${this.vuexNamespace}/errors`]
        }
    }
}
