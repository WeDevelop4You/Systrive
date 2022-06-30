import FormMethods from "./FormMethods";
import ComponentProperties from "../ComponentProperties";

export default {
    mixins: [
        FormMethods,
        ComponentProperties
    ],

    data() {
        return {
            key: this.value.data.key,
            vuexNamespace: this.value.data.vuexNamespace,
        }
    },

    computed: {
        data: {
            get() {
                return this.$store.getters[`${this.vuexNamespace}/data`]
            },

            set(data) {
                this.$store.commit(`${this.vuexNamespace}/setData`, data)
            }
        },

        isDisabled() {
            return this.value.data.disabledOnLoading && this.$loading;
        },

        error() {
            return this.$store.getters[`${this.vuexNamespace}/error`]
        },

        errors() {
            return this.$store.getters[`${this.vuexNamespace}/errors`]
        }
    },

    created() {
        const value = this.value.content.value

        if (value) {
            this.data[this.key] = value
        }
    }
}
