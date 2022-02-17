<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="100%"
        max-width="450px"
    >
        <v-card>
            <v-card-title class="gap-3 flex-nowrap justify-space-between">
                <slot name="title">
                    <span class="headline">{{ title }}</span>
                    <v-btn
                        icon
                        @click="resetDelete"
                    >
                        <v-icon>fas fa-times</v-icon>
                    </v-btn>
                </slot>
            </v-card-title>
            <v-card-text>{{ deleteMessage }}</v-card-text>
            <v-card-actions>
                <l-buttons>
                    <template v-if="forceDeletable">
                        <v-btn
                            small
                            color="secondary"
                            :disabled="$loading"
                            @click="$emit('force-delete')"
                        >
                            {{ $vuetify.lang.t('$vuetify.word.delete.force') }}
                        </v-btn>
                    </template>
                    <template v-if="!hideDeleteButton">
                        <v-btn
                            small
                            color="error"
                            :disabled="$loading"
                            @click="$emit('delete')"
                        >
                            {{ deleteButton || $vuetify.lang.t('$vuetify.word.delete.delete') }}
                        </v-btn>
                    </template>
                    <v-btn
                        text
                        small
                        :disabled="$loading"
                        @click="resetDelete"
                    >
                        {{ $vuetify.lang.t('$vuetify.word.cancel.cancel') }}
                    </v-btn>
                </l-buttons>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import LButtons from "../../layout/Buttons"

    export default {
        name: "DeleteDialog",

        components: {
            LButtons
        },

        props: {
            title: {
                required: true,
                type: String
            },

            vuexNamespace: {
                required: true,
                type: String
            },

            forceDeletable: {
                type: Boolean,
                default: false,
            },

            deleteButton: {
                type: String,
                default: null,
            }
        },

        computed: {
            dialog() {
                const dialog = this.$store.getters[`${this.vuexNamespace}/isDeleteDialogOpen`]

                dialog ? this.$emit('open') : this.$emit('close')

                return dialog
            },

            deleteMessage() {
                return this.$store.getters[`${this.vuexNamespace}/deleteMessage`]
            },

            hideDeleteButton() {
                return this.$store.getters[`${this.vuexNamespace}/hideDeleteButton`]
            }
        },

        methods: {
            resetDelete() {
                this.$store.commit(`${this.vuexNamespace}/resetDelete`)
            }
        }
    }
</script>
