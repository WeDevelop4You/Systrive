import FormMethods from "../../mixins/FormMethods";
import {get as _get, set as _set} from "lodash";
import MainComponentBase from "./MainComponentBase";

export default {
    extends: MainComponentBase,

    mixins: [
        FormMethods,
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

        getValue() {
            return _get(this.data, this.key)
        },

        isDisabled() {
            return this.value.data.disabledOnLoading && this.$loading;
        },

        error() {
            return this.$store.getters[`${this.vuexNamespace}/error`]
        },

        errors() {
            return this.$store.getters[`${this.vuexNamespace}/errors`]
        },

        errorMessages() {
            return this.errors[this.key]
        }
    },

    created() {
        if (!this.getValue) {
            const value = this.value.content.value ?? this.value.content.defaultValue

            this.setValue(value)
        }
    },

    methods: {
        getRef() {
            return this.$refs[this.key]
        },

        setValue(value) {
            this.clearError(this.key)

            this.data = Object.assign({}, _set(this.data, this.key, value))
        },

        isset(data, key) {
            return Object.prototype.hasOwnProperty.call(data, key)
        }
    }
}
