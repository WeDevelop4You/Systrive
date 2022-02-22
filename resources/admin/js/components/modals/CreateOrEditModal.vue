<template>
    <modal-base
        ref="modal"
        v-model="show"
        :icon="icon"
        :button-type="buttonType"
        persistent
        width="700px"
    >
        <template #button>
            <slot name="button" />
        </template>
        <card-base
            :title="title"
        >
            <template #button>
                <close-button @close="close" />
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
    import ModalButtonProperties from "../../mixins/ModalButtonProperties";
    import CloseButton from "../CloseButton";

    export default {
        name: "CreateOrEditModal",

        components: {
            CloseButton
        },

        mixins: [
            ModalBaseProperties,
            ModalButtonProperties
        ]
    }
</script>
