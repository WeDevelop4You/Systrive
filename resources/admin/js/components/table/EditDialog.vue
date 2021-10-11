<template>
    <div>
        <template v-if="!disableCreate">
            <v-btn color="primary" class="mb-2 ml-4" @click="changeDialog(true)">{{ buttonTitle }}</v-btn>
        </template>
        <v-dialog :value="dialog" max-width="700" persistent :fullscreen="fullscreen">
            <v-card>
                <v-card-title>
                    <slot name="title">
                        <span class="headline">{{ formTitle }}</span>
                        <v-spacer/>
                        <v-btn icon @click="changeDialog(false)">
                            <v-icon>fas fa-times</v-icon>
                        </v-btn>
                    </slot>
                </v-card-title>
                <v-card-text>
                    <slot></slot>
                </v-card-text>
                <v-card-actions class="px-6">
                    <slot name="action">
                        <v-spacer></v-spacer>
                        <v-btn text @click="changeDialog(false)" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.cancel') }}</v-btn>
                        <v-btn color="primary" @click="$emit('save')" :disabled="$loading">{{ $vuetify.lang.t('$vuetify.word.save') }}</v-btn>
                    </slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "EditDialog",

        props: {
            buttonTitle: {
                required: true,
                type: String
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

            fullscreen: {
                type: Boolean,
                default: false
            }
        },

        computed: {
            dialog() {
                return this.$store.getters[`${this.vuexNamespace}/editDialog`]
            }
        },

        methods: {
            changeDialog(value) {
                this.$store.commit(`${this.vuexNamespace}/changeEditDialog`, value)
            }
        }
    }
</script>
