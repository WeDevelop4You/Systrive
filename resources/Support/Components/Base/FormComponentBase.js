import Logic from "../../Helpers/Logic";
import ComponentBase from "./ComponentBase";
import {get as _get, set as _set} from "lodash";
import FormMethods from "../../Mixins/FormMethods";

export default {
    extends: ComponentBase,

    mixins: [
        FormMethods,
    ],

    data() {
        return {
            key: this.value.data.key,
            hint: this.value.attributes.hint,
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

        error() {
            return this.$store.getters[`${this.vuexNamespace}/error`]
        },

        errors() {
            return this.$store.getters[`${this.vuexNamespace}/errors`]
        },

        errorMessages() {
            return this.errors[this.component.data.errorKey ?? this.key]
        },

        hideDetails() {
            if (this.component.data.hideDetails instanceof Object) {
                return new Logic(this.component.data.hideDetails).call(this.data)
            }

            return this.component.data.hideDetails
        },

        isDisabled() {
            return this.value.data.disabled || (this.value.data.disabledOnLoading && this.$loading);
        },

        isHidden() {
            if (this.isset(this.component.data, 'hiddenLogic')) {
                for (const logic of this.component.data.hiddenLogic) {
                    if (new Logic(logic).call(this.data)) {
                        return false;
                    }
                }
            }

            return true
        }
    },

    created() {
        if (this.getValue === undefined) {
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
            this.createHint(value)

            this.data = Object.assign({}, _set(this.data, this.key, value))
        },

        createHint(value) {
            if (this.component.data.hintWithInput) {
                let input = ''

                if (value) {
                    if (typeof value === 'string') {
                        input = value
                    }

                    if (typeof value === 'object') {
                        input = value.text
                    }
                }

                this.component.attributes.hint = this.hint + input
            }
        }
    }
}
