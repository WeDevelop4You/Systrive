<template>
    <v-dialog
        v-model="value"
        :width="width"
        :elevation="$config.elevation"
        :persistent="persistent"
        :fullscreen="fullscreen"
        rounded="lg"
        @input="change($event)"
    >
        <template
            v-if="buttonType !== 'none'"
            #activator="{ on }"
        >
            <template v-if="buttonType === 'button'">
                <slot name="button" />
            </template>
            <template v-if="buttonType === 'icon'">
                <v-btn
                    :disabled="$loading"
                    icon
                    @click="open"
                    v-on="on"
                >
                    <v-icon>{{ icon }}</v-icon>
                </v-btn>
            </template>
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
                type: String,
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

            icon: {
                type: String,
                default: ''
            },

            buttonType: {
                type: String,
                default: 'none'
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
                console.log(value)

                value ? this.$emit('opened') : this.$emit('closed')
            }
        }
    }
</script>
