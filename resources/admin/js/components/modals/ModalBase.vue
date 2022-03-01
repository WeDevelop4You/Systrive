<template>
    <v-dialog
        v-if="render"
        v-model="value"
        :width="width"
        :elevation="$config.elevation"
        :persistent="persistent"
        :fullscreen="fullscreen"
        :hide-overlay="hideOverlay"
        :no-click-animation="noClickAnimation"
        :transition="transition"
        @input="change($event)"
    >
        <template #activator="{ on }" v-if="$slots.button">
            <slot name="button" v-on="on" />
        </template>
        <slot />
    </v-dialog>
</template>

<script>
    export default {
        name: "ModalBase",

        props: {
            value: {
                required: true,
                type: Boolean,
            },

            width: {
                type: [String, Number],
                default: ''
            },

            persistent: {
                type: Boolean,
                default: false
            },

            fullscreen: {
                type: Boolean,
                default: false
            },

            hideOverlay: {
                type: Boolean,
                default: false,
            },

            noClickAnimation: {
                type: Boolean,
                default: false
            },

            transition: {
                type: String,
                default: undefined
            },

            rerender: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                render: true,
            }
        },

        watch: {
            value: function (value) {
                if (value) {
                    this.render = true
                } else if (this.rerender) {
                    setTimeout(() => {
                        this.render = false
                    }, 300)
                }
            }
        },

        methods: {
            open() {
                this.$emit('input', true)
            },

            close() {
                this.$emit('input', false)
            },

            change(value) {
                value ? this.$emit('opened') : this.$emit('closed')
            }
        }
    }
</script>
