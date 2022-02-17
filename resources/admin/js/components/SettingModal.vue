<template>
    <v-dialog
        v-model="value"
        :width="width"
        :elevation="$config.elevation"
        rounded="lg"
        persistent
    >
        <template #activator="{ on }">
            <v-btn
                small
                outlined
                color="primary"
                @click="open"
                v-on="on"
            >
                {{ buttonTitle }}
            </v-btn>
        </template>
        <v-card
            :elevation="$config.elevation"
            outlined
            rounded="lg"
        >
            <v-card-title class="gap-3 flex-nowrap justify-space-between">
                <span
                    class="headline"
                    style="width: max-content"
                >{{ formTitle }}</span>
                <v-btn
                    icon
                    @click="close"
                >
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <slot name="subtitle" />
            <v-card-text
                class="pb-0"
                :class="{'px-0': noPadding}"
            >
                <slot />
            </v-card-text>
            <template v-if="!noAction">
                <v-card-actions>
                    <l-buttons>
                        <slot name="action">
                            <v-btn
                                small
                                color="primary"
                                :disabled="$loading"
                                @click="$emit('save')"
                            >
                                {{ $vuetify.lang.t('$vuetify.word.save') }}
                            </v-btn>
                        </slot>
                    </l-buttons>
                </v-card-actions>
            </template>
        </v-card>
    </v-dialog>
</template>

<script>
    import LButtons from "../layout/Buttons";
    export default {
        name: "SettingModal",

        components: {
            LButtons
        },

        props: {
            value: {
                required: true,
                type: Boolean
            },

            formTitle: {
                required: true,
                type: String
            },

            buttonTitle: {
                required: true,
                type: String,
            },

            width: {
                type: String,
                default: "min-content"
            },

            noAction: {
                type: Boolean,
                default: false
            },

            noPadding: {
                type: Boolean,
                default: false
            },
        },

        methods: {
            open() {
                this.$emit('open')
                this.$emit('input', true)
            },

            close() {
                this.$emit('close')
                this.$emit('input', false)
            }
        }
    }
</script>
