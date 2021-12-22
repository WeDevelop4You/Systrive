<template>
    <div>
        <template v-if="!disableCreate && $auth.can(createPermission)">
            <v-btn
                small
                color="primary"
                class="ml-4"
                @click="setDialog"
            >
                {{ buttonTitle }}
            </v-btn>
        </template>
        <v-dialog
            v-if="render"
            v-model="dialog"
            max-width="700"
            persistent
            :fullscreen="fullscreen"
        >
            <v-card>
                <v-card-title>
                    <slot name="title">
                        <span class="headline">{{ formTitle }}</span>
                        <v-spacer />
                        <v-btn
                            icon
                            @click="resetDialog"
                        >
                            <v-icon>fas fa-times</v-icon>
                        </v-btn>
                    </slot>
                </v-card-title>
                <v-card-text>
                    <slot />
                </v-card-text>
                <v-card-actions class="px-6">
                    <slot name="action">
                        <v-spacer />
                        <v-btn
                            text
                            :disabled="$loading"
                            @click="resetDialog"
                        >
                            {{ $vuetify.lang.t('$vuetify.word.cancel.cancel') }}
                        </v-btn>
                        <v-btn
                            color="primary"
                            :disabled="$loading"
                            @click="$emit('save')"
                        >
                            {{ $vuetify.lang.t('$vuetify.word.save') }}
                        </v-btn>
                    </slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "CreateOrEditDialog",

        props: {
            buttonTitle: {
                type: String,
                default: 'undefined'
            },

            formTitle: {
                required: true,
                type: String
            },

            vuexNamespace: {
                required: true,
                type: String
            },

            disableCreate: {
                type: Boolean,
                default: false
            },

            createPermission: {
                type: String,
                default: undefined
            },

            fullscreen: {
                type: Boolean,
                default: false
            },

            rerender: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                render: false,
            }
        },

        computed: {
            dialog() {
                const dialog = this.$store.getters[`${this.vuexNamespace}/isCreateOrEditDialogOpen`]

                dialog ? this.$emit('opened') : this.$emit('closed')

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
            setDialog() {
                this.$store.commit(`${this.vuexNamespace}/setCreate`)
            },

            resetDialog() {
                this.$store.commit(`${this.vuexNamespace}/resetCreateOrEdit`)
            }
        }
    }
</script>
