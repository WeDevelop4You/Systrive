<template>
    <v-dialog v-model="dialog" persistent max-width="450">
        <v-card>
            <v-card-title class="text-h5">
                <slot name="title">
                    <span class="headline">{{ title }}</span>
                    <v-spacer/>
                    <v-btn icon @click="resetDelete">
                        <v-icon>fas fa-times</v-icon>
                    </v-btn>
                </slot>
            </v-card-title>
            <v-card-text>{{ deleteMessage }}</v-card-text>
            <v-card-actions class="flex-wrap gap-3 justify-end">
                <template v-if="forceDeletable">
                    <v-btn color="secondary" @click="$emit('force-delete')" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.force-delete') }}</v-btn>
                </template>
                <v-btn color="error" @click="$emit('delete')" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.delete') }}</v-btn>
                <v-btn text @click="resetDelete" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.cancel') }}</v-btn>
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
            }
        },

        computed: {
            dialog() {
                return this.$store.getters[`${this.vuexNamespace}/deleteDialog`]
            },

            deleteMessage() {
                return this.$store.getters[`${this.vuexNamespace}/deleteMessage`]
            }
        },

        methods: {
            resetDelete() {
                this.$store.commit(`${this.vuexNamespace}/resetDelete`)
            }
        }
    }
</script>
