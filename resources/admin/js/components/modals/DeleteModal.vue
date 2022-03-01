<template>
    <modal-base
        ref="modal"
        v-model="show"
        persistent
        width="450"
    >
        <card-base :title="title">
            <template #button>
                <close-button @close="close" />
            </template>
            {{ content }}
            <template #actions>
                <v-btn
                    v-if="forceDeletable"
                    small
                    color="secondary"
                    :disabled="$loading"
                    @click="$emit('forceDestroy')"
                >
                    {{ $vuetify.lang.t('$vuetify.word.delete.force') }}
                </v-btn>
                <v-btn
                    v-if="!isDeleted"
                    small
                    color="error"
                    :disabled="$loading"
                    @click="$emit('destroy')"
                >
                    {{ $vuetify.lang.t('$vuetify.word.delete.delete') }}
                </v-btn>
                <v-btn
                    text
                    small
                    :disabled="$loading"
                    @click="close"
                >
                    {{ $vuetify.lang.t('$vuetify.word.cancel.cancel') }}
                </v-btn>
            </template>
        </card-base>
    </modal-base>
</template>

<script>
    import ModalBase from "./ModalBase";
    import CardBase from "../cards/CardBase";
    import CloseButton from "../CloseButton";
    import ModalBaseProperties from "../../mixins/ModalBaseProperties";

    export default {
        name: "DeleteModal",

        mixins: [
            ModalBaseProperties
        ],

        components: {
            CardBase,
            ModalBase,
            CloseButton,
        },

        props: {
            content: {
                required: true,
                type: String
            },

            forceDeletable: {
                type: Boolean,
                default: false,
            },

            isDeleted: {
                type: Boolean,
                default: false,
            }
        },
    }
</script>
