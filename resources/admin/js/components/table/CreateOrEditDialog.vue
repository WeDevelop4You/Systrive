<template>
    <div>
        <template v-if="!disableCreate && $auth.can(createPermission)">
            <v-btn
                small
                color="primary"
                @click="setDialog"
            >
                {{ buttonTitle }}
            </v-btn>
        </template>
        <v-dialog
            v-if="render"
            v-model="dialog"
            :fullscreen="fullscreen"
            :elevation="$config.elevation"
            max-width="700"
            persistent
        >
            <v-card
                :elevation="$config.elevation"
                outlined
                rounded="lg"
            >
                <v-card-title class="gap-3 flex-nowrap justify-space-between">
                    <slot name="title">
                        <span class="headline">{{ formTitle }}</span>
                        <v-btn
                            icon
                            @click="resetDialog"
                        >
                            <v-icon>fas fa-times</v-icon>
                        </v-btn>
                    </slot>
                </v-card-title>
                <v-card-text class="pb-0">
                    <slot />
                </v-card-text>
                <v-card-actions>
                    <f-buttons>
                        <slot name="action">
                            <v-btn
                                text
                                small
                                :disabled="$loading"
                                @click="resetDialog"
                            >
                                {{ $vuetify.lang.t('$vuetify.word.cancel.cancel') }}
                            </v-btn>
                            <v-btn
                                small
                                color="primary"
                                :disabled="$loading"
                                @click="$emit('save')"
                            >
                                {{ $vuetify.lang.t('$vuetify.word.save') }}
                            </v-btn>
                        </slot>
                    </f-buttons>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import FButtons from "../../layout/Buttons";

    export default {
        name: "CreateOrEditDialog",

        components: {
            FButtons,
        },

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
