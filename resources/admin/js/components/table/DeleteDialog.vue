<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="450"
    >
        <v-card>
            <v-card-title class="text-h5">
                <slot name="title">
                    <span class="headline">{{ title }}</span>
                    <v-spacer />
                    <v-btn
                        icon
                        @click="resetDelete"
                    >
                        <v-icon>fas fa-times</v-icon>
                    </v-btn>
                </slot>
            </v-card-title>
            <v-card-text>{{ deleteMessage }}</v-card-text>
            <v-card-actions class="flex-wrap gap-3 justify-end">
                <template v-if="forceDeletable">
                    <v-btn
                        color="secondary"
                        :disabled="$loading"
                        @click="$emit('force-delete')"
                    >
                        {{ $vuetify.lang.t('$vuetify.word.delete.force') }}
                    </v-btn>
                </template>
                <template v-if="!hideDeleteButton">
                    <v-btn
                        color="error"
                        :disabled="$loading"
                        @click="$emit('delete')"
                    >
                        {{ deleteButton || $vuetify.lang.t('$vuetify.word.delete.delete') }}
                    </v-btn>
                </template>
                <v-btn
                    text
                    :disabled="$loading"
                    @click="resetDelete"
                >
                    {{ $vuetify.lang.t('$vuetify.word.cancel') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "DeleteDialog",

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
