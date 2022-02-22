<template>
    <modal-base
        ref="modal"
        v-model="show"
        :width="width"
        persistent
        button-type="button"
    >
        <template #button>
            <v-btn
                small
                outlined
                color="primary"
                @click="open"
            >
                {{ button }}
            </v-btn>
        </template>
        <card-base
            :title="title"
            :no-action="noAction"
            :no-padding="noPadding"
        >
            <template #button>
                <close-button @close="close" />
            </template>
            <template #subtitle>
                <slot name="subtitle" />
            </template>
            <slot />
            <template #action>
                <v-btn
                    small
                    text
                    :disabled="$loading"
                    @click="close"
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
            </template>
        </card-base>
    </modal-base>
</template>

<script>
    import ModalBaseProperties from "../../mixins/ModalBaseProperties";
    import CloseButton from "../CloseButton";

    export default {
        name: "SettingModal",

        components: {
            CloseButton
        },

        mixins: [
            ModalBaseProperties,
        ],

        props: {
            width: {
                required: true,
                type: String
            },

            button: {
                required: true,
                type: String
            },

            noAction: {
                type: Boolean,
                default: false
            },

            noPadding: {
                type: Boolean,
                default: false,
            }
        }
    }
</script>
