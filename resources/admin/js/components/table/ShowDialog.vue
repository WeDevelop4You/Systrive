<template>
    <v-dialog
        v-if="render"
        v-model="dialog"
        fullscreen
        persistent
        hide-overlay
        transition="dialog-bottom-transition"
    >
        <v-card :color="$vuetify.theme.dark ? '#121212' : ''">
            <v-toolbar dense>
                <v-toolbar-title
                    class="ml-5"
                    v-text="title"
                />
                <v-spacer />
                <v-btn
                    class="mr-5"
                    icon
                    @click="resetDialog"
                >
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-progress-linear
                    absolute
                    bottom
                    indeterminate
                    :active="$loading"
                    color="primary"
                />
            </v-toolbar>
            <v-card-text class="my-5">
                <slot />
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "ShowDialog",

        props: {
            title: {
                required: true,
                type: String
            },

            vuexNamespace: {
                required: true,
                type: String
            },

            rerender: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                render: false
            }
        },

        computed: {
            dialog() {
                const dialog = this.$store.getters[`${this.vuexNamespace}/isShowDialogOpen`]

                dialog ? this.$emit('open') : this.$emit('close')

                return dialog
            }
        },

        watch: {
            dialog: function (value) {
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
            resetDialog() {
                this.$store.commit(`${this.vuexNamespace}/resetShow`)
            }
        }
    }
</script>
