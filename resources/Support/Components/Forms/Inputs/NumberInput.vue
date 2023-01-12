<template>
    <v-text-field
        v-show="isHidden"
        ref="number"
        v-bind="component.attributes"
        v-model="number"
        :disabled="isDisabled"
        :label="component.content.label"
        :error-messages="errorMessages"
        :hide-details="hideDetails"
        :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
        @input="format($event)"
    />
</template>


<script>
import {set as _set} from "lodash";
import FormComponentBase from "../../Base/FormComponentBase";

export default {
    name: "NumberInput",

    extends: FormComponentBase,

    data() {
        return {
            total: 6,
            places: 2,
            regex: '',
            number: '',
            original: '',
            isNumeric: false
        }
    },

    created() {
        const isNumeric = this.component.data.isNumeric || false

        this.isNumeric = isNumeric
        this.number = this.getValue
        this.original = this.getValue
        this.total = this.component.data.total
        this.places = this.component.data.places
        this.regex = isNumeric ? '[^0-9.]' : '[^0-9]'
    },

    methods: {
        format(value) {
            this.$nextTick(() => {
                const target = this.$refs.number.$refs.input
                const currentCursorPosition = target.selectionStart

                let formattedValue = value.replace(',', '.').replace(new RegExp(this.regex, 'g'), '')

                if (this.isNumeric) {
                    formattedValue = this.formatNumeric(formattedValue);
                }

                if (value.startsWith('-')) {
                    formattedValue = `-${formattedValue}`
                }

                this.setValue(formattedValue)

                this.$nextTick(() => {
                    const isDirty = formattedValue !== value
                    const newCursorPosition = currentCursorPosition - isDirty

                    target.setSelectionRange(currentCursorPosition, newCursorPosition, 'none')
                });
            })

            this.clearError(this.key)
        },

        setValue(value) {
            this.number = value
            this.original = value
            this.data = Object.assign({}, _set(this.data, this.key, value))
        },

        formatNumeric(value) {
            const hasDot = value.includes('.')
            const index = hasDot ? this.findDotIndex(value) : value.length

            const integer = value.substring(0, index)
                .replace('.', '')

            const decimal = value.substring(index + 1)
                .replace('.', '')
                .substring(0, this.places)

            let formatted = integer

            if (integer.length > this.total) {
                formatted = integer.slice(-this.total)
            }

            if (hasDot) {
                formatted += `.${decimal}`
            }

            return formatted
        },

        findDotIndex(value) {
            let index = value.indexOf('.');

            if (this.original !== null) {
                value.split('').every((val, i) => {
                    if (val !== this.original.charAt(i) && val === '.') {
                        index = i

                        return false
                    }

                    return true
                });
            }

            return index
        }
    }
}
</script>
